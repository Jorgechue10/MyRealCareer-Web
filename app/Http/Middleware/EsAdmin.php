<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EsAdmin
{
    /**
     * Verificar si un usuario tiene el rol de "administrador"
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->esAdmin()) {
            return $next($request);
        }

        return redirect()->back();
    }
}
