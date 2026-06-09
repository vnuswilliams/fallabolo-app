<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectRegisteredUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          // Si le visiteur a déjà créé un compte (cookie présent), on l'envoie vers /login
        if ($request->cookie('registered')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
