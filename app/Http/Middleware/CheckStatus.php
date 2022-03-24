<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token =$request->header("api_key");

        if ($token == NULL) {
            return response()->json([
              'status' => 401,
              'message' => 'Acceso no autorizado',
            ], 401);
          }
          else
          if ($token) {

            if ($token == $_ENV["TOKEN"]) {
                return $next($request);
            }else{
                return response()->json([
                    'status' => 401,
                    'message' => 'Acceso no autorizado',
                  ], 401);
            }
          }
    }
}
