<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleMiddleware
{
    public function handle(Request $request, Closure $next, $role = null): mixed
    {
        if (!$request->user()) {
            return redirect('login');
        }

        if ($role && $request->user()->role?->value !== $role) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
