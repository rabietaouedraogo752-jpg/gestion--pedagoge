<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GererConnexion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // lorsqu'un utilisateur n'a pas de rôle précis, il va bloquer l' accès 
        if (auth()->user()->role !== $role) {
            abort(403); // accès interdit
        }

        return $next($request);
    }
}
