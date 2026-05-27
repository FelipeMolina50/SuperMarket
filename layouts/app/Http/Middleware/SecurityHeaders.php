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

        // Seguridad Básica
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), midi=(), sync-xhr=(), microphone=(), camera=(), magnetometer=(), gyroscope=(), fullscreen=(self), payment=()');

        // CSP Refinado - Intentamos ser lo más estrictos posible dentro de lo que permite la app
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com https://cdn.tailwindcss.com; " .
               "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; " .
               "img-src 'self' data: https://images.unsplash.com; " .
               "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net; " .
               "connect-src 'self'; " .
               "frame-ancestors 'self'; " .
               "upgrade-insecure-requests;";
        
        $response->headers->set('Content-Security-Policy', $csp);

        // Eliminar rastro de PHP/Laravel
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
