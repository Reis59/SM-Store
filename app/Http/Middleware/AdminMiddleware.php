<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }
        // return redirect('/'); // Redirect non-admin users to the homepage or any other page
        return abort(403, 'Unauthorized action.'); // Or you can return a 403 Forbidden response
    }
}
