<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Validate the bearer token.
     */
    private function tokenIsValid(string $token): bool
    {
        // Implement your token validation logic here
        return $token === config('app.api_token');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!$this->tokenIsValid($request->bearerToken())) {
            return response()->json(
                [
                    'error' => 'Unauthorized'
                ],
                401
            );
        }
        return $next($request);

        //codigo apos a requisição ser processada

    }
}
