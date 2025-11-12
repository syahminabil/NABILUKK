<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userRole = trim(strtolower(Auth::user()->role)); // <= pakai trim + strtolower
        $requiredRole = trim(strtolower($role));

        if ($userRole !== $requiredRole) {
            abort(403, 'Unauthorized access. Required role: ' . $role);
        }

        return $next($request);
    }
}
