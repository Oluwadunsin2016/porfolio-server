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


// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;

// class CorsMiddleware
// {
//     public function handle(Request $request, Closure $next)
//     {
//         // Set headers for CORS
//         $headers = [
//             'Access-Control-Allow-Origin' => '*',
//             'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
//             'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
//         ];

//         // Handle preflight OPTIONS request
//         if ($request->isMethod('OPTIONS')) {
//             return response()->json('OK', 200, $headers);
//         }

//         // Apply headers to response for actual requests
//         $response = $next($request);
//         foreach ($headers as $key => $value) {
//             $response->headers->set($key, $value);
//         }

//         return $response;
//     }
// }



namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    protected $allowedOrigins = [
        'http://localhost:5173','http://localhost:5174', 'https://portfolio-upload-plum.vercel.app', 'https://vue-portfolio-alpha-three.vercel.app', 'https://porfolio-server-dnqn.onrender.com'
    ];

    public function handle(Request $request, Closure $next)
    {
        $origin = $request->headers->get('origin');

        // Check if the origin matches any allowed base origin
        if (in_array($origin, $this->allowedOrigins)) {
            $headers = [
                'Access-Control-Allow-Origin' => $origin,
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PATCH, PUT, DELETE',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
            ];
        } else {
            $headers = [
                'Access-Control-Allow-Origin' => 'null',
            ];
        }

        // Handle preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200, $headers);
        }

        // Apply headers to the response for actual requests
        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}

