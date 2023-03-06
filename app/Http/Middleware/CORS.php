<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->headers->set("Access-Control-Allow-Credentials", "true");
        $response->headers->set("Access-Control-Allow-Methods", "POST, GET, OPTIONS, DELETE, PUT, PATCH"); //Make sure you remove those you do not want to support
        $response->headers->set("Access-Control-Allow-Headers", "Content-Type, Accept, Authorization, X-Requested-With, Application");

        return $response;
    }
}
