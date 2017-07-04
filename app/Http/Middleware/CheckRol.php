<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;



class CheckRol
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {

        if (Auth::user()->es($role) || Auth::user()->es('admin')){
            return $next($request);    
        }else{
            dd('Acceso negado rol insuficiente');
        }
        
    }
}
