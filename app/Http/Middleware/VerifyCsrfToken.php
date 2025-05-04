<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyCsrfToken
{
    /**
     * Routes to exclude from CSRF protection.
     */
    protected $except = [
        '/login',
        '/register',
        '/logout',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isReading($request) || $this->inExceptArray($request)) {
            return $next($request);
        }

        // Here, you'd normally verify token — but skipping that logic for simplicity
        // For actual CSRF protection, you'd check the token here

        // Simulate rejection (optional if you want actual protection)
        return response('CSRF token mismatch.', 419);
    }

    protected function isReading(Request $request): bool
    {
        return in_array($request->method(), ['HEAD', 'GET', 'OPTIONS']);
    }

    protected function inExceptArray(Request $request): bool
    {
        foreach ($this->except as $except) {
            if ($request->is(trim($except, '/'))) {
                return true;
            }
        }

        return false;
    }
}
