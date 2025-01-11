<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Nastavenie hlavičiek CORS
        $response->headers->set('Access-Control-Allow-Origin', '*'); // Povoliť všetky originy (*)
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS'); // Povolené metódy
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With'); // Povolené hlavičky

        // Riešenie predbežných OPTIONS požiadaviek
        if ($request->getMethod() === 'OPTIONS') {
            $response->setStatusCode(200);
        }

        return $response;
    }
}
