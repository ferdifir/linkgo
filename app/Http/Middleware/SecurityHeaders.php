<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->headers->set('Content-Security-Policy', "default-src 'self'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline'; font-src 'self' data:; frame-src https://www.google.com; img-src 'self' data: https:");
        if (config('session.secure') && ! $request->is('api/*')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=15552000');
        }
        if ($request->is('admin') || $request->is('api/admin/*')) {
            $response->headers->set('Cache-Control', 'no-store');
        }

        return $response;
    }
}
