<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class AddToken
{
    public function handle($request, Closure $next){
        $token = isset($_COOKIE["jwt_token"])?$_COOKIE["jwt_token"]:"";
        $request->headers->set("Authorization", "Bearer $token");
        $response = $next($request);
        return $response;
    }
}
