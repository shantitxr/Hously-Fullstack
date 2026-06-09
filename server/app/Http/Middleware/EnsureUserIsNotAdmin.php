<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsNotAdmin
{
    public function handle(Request $request, Closure $next)
    {
        abort_if(auth()->user()->role === 'admin', 403, 'Admins do not have personal listings.');
        return $next($request);
    }
} 