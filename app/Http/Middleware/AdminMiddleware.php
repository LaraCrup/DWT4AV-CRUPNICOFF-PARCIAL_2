<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado y tiene rol_id = 1
        if (auth()->check() && auth()->user()->rol_id == 1) {
            return $next($request);
        }

        // Si no es admin, redirigir a home con mensaje de error
        return redirect()->route('home')
            ->with('error', 'No tienes permiso para acceder al área de administración');
    }
}
