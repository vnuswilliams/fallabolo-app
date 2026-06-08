<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuspension
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            $isSuspended = false;

            if ($user->candidateProfile && $user->candidateProfile->is_suspended) {
                $isSuspended = true;
            }

            if ($user->recruiterProfile && $user->recruiterProfile->is_suspended) {
                $isSuspended = true;
            }

            if ($isSuspended && ! $request->routeIs('suspended') && ! $request->routeIs('logout')) {
                return redirect()->route('suspended');
            }
        }

        return $next($request);
    }
}
