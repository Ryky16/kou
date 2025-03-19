<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Vérifie si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect('login');
        }

        // Vérifie si l'utilisateur a le rôle requis
        $user = Auth::user();
        if (!$user->hasRole($role)) {
            abort(403, 'Accès interdit');
        }

        return $next($request);
    }
}