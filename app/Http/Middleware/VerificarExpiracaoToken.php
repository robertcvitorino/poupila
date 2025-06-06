<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarExpiracaoToken
{
    public function handle(Request $request, Closure $next): Response
    {

        // Checa se o usuário está autenticado
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        // Checa se existe o token e se tem expires_at
        $token = $request->user()->currentAccessToken();

        if ($token && $token->expires_at && now()->greaterThan($token->expires_at)) {
            // Token expirado!
            return response()->json(['erro' => 'Token expirado. Faça login novamente ou use o refresh token.'], 401);
        }

        return $next($request);
    }
}
