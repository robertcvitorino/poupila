<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrarUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    // Cadastro
    public function registrar(RegistrarUsuarioRequest $request)
    {
        $usuarioCriado = Usuario::where('email', $request->email)->first();

        if ($usuarioCriado) {
            throw ValidationException::withMessages([
                'email' => 'O email ja foi cadastrado.'
            ]);
        }

        $usuario = Usuario::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Cria token
        $token = $usuario->createToken('token')->plainTextToken;

        return response()->json([
            'usuario' => $usuario,
            'token'   => $token,
        ], 201);
    }

    // Login
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais estão incorretas.'],
            ]);
        }

        // Gera token de acesso (válido por, por exemplo, 30 minutos)
        $accessToken = $usuario->createToken(
            'access_token',
            [],
            now()->addMinutes(30) // expira em 30 minutos
        );
        $accessToken->accessToken->tipo = 'access';
        $accessToken->accessToken->expires_at = now()->addMinutes(30);
        $accessToken->accessToken->save();

        // Gera refresh token (válido por 7 dias, sem escopo)
        $refreshToken = $usuario->createToken(
            'refresh_token',
            [],
            now()->addDays(7)
        );
        $refreshToken->accessToken->tipo = 'refresh';
        $refreshToken->accessToken->expires_at = now()->addDays(7);
        $refreshToken->accessToken->save();

        return response()->json([
            'usuario' => $usuario,
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
        ]);
    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required|string',
        ]);

        $tokenId = $request->refresh_token; // Supondo que você está enviando o ID do token
        $token = PersonalAccessToken::find($tokenId);

        if($token !== null) {
            if (!$token || $token->tipo !== 'refresh' || $token->expires_at->isPast()) {
                return response()->json(['erro' => 'Refresh token inválido ou expirado'], 401);
            }

            $usuario = $token->tokenable;

            // Revoga o refresh token antigo
            $token->delete();

        }
        $usuario = $token->tokenable;

        // Gera novo access token
        $accessToken = $usuario->createToken('access_token_' . uniqid());
        $accessToken->accessToken->tipo = 'access';
        $accessToken->accessToken->expires_at = now()->addMinutes(30);
        $accessToken->accessToken->save();

        // Gera novo refresh token
        $refreshToken = $usuario->createToken('refresh_token_' . uniqid());
        $refreshToken->accessToken->tipo = 'refresh';
        $refreshToken->accessToken->expires_at = now()->addDays(30);
        $refreshToken->accessToken->save();

        return response()->json([
            'access_token' => $accessToken->plainTextToken,
        ]);
    }
}
