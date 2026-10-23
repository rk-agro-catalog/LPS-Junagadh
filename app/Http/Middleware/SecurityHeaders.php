<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and enforce OWASP-compliant defensive security headers.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 1. Prevent Clickjacking: Prevent website from being embedded into malicious iframes
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 2. Prevent MIME-type Sniffing: Prevent browsers from trying to guess content types
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 3. Referrer Policy: Protect user privacy & prevent token/URL leakage
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 4. Permissions Policy: Restrict browser hardware/feature access
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self)');

        // 5. Cross-Site Scripting Protection filter
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // 6. Hide server technology info (PHP version fingerprinting)
        if (function_exists('header_remove')) {
            @header_remove('X-Powered-By');
        }

        return $response;
    }
}
