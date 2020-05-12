<?php

namespace App\Http\Middleware;

use Closure;

class DocenteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usuario_actual=\Auth::user();
        if($usuario_actual->tipo_usuario=='docente'){
           return $next($request);
        }
        else{
          return redirect()->back();
        }
    }
}
