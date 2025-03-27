<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        if (!$request->user('admin')) {
            return redirect('/admin/login');
        }

        // For simplicity, we'll just check if the user is an admin
        // In a real app, you'd check for specific roles
        if ($request->user('admin')->is_super_admin) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
