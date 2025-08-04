<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Verifica si el usuario tiene el rol requerido
        if (Auth::user()->role->name !== $role) {
            return redirect('/home'); // Redirige si no tiene el rol
        }

        return $next($request);
    }
}

