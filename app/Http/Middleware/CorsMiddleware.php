<?php

// namespace App\Http\Middleware;

// use Closure;

// class CorsMiddleware
// {
//     public function handle($request, Closure $next)
//     {
//         $response = $next($request);

//         $response->headers->set('Access-Control-Allow-Origin', '*');
//         $response->headers->set('Access-Control-Allow-Methods', '*');
//         $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

//         return $response;
//     }
// }


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Set headers for CORS
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
        ];

        // Handle preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200, $headers);
        }

        // Apply headers to response for actual requests
        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}

