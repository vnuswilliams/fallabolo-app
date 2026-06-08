<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole(RoleEnum::ADMIN->value)) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->hasRole(RoleEnum::RECRUITER->value)) {
                return redirect()->route('recruiter.dashboard');
            }

            if ($user->hasRole(RoleEnum::CANDIDATE->value)) {
                return redirect()->route('candidate.dashboard');
            }
        }

        return $next($request);
    }
}
