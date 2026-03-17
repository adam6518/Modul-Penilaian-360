<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        return $response->header(
            'Strict-Transport-Security',
            'max-age=31536000; includeSubDomains'
        );
    }
}