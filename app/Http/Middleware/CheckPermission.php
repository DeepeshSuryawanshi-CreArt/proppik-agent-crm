<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        foreach ($permissions as $permission) {
            if (auth()->user()->hasPermissionTo($permission)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
