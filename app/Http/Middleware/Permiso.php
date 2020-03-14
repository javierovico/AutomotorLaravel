<?php

namespace App\Http\Middleware;

use Closure;

class Permiso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $nombrePermiso)
    {
        foreach($request->user()->rol->permisos as $permiso){
            if($permiso->nombre == $nombrePermiso){
                return $next($request);
            }
        }
        abort(403,['message'=>'sin permiso']);
    }
}
