<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission = null): Response
    {
        if (!$request->user('admin')) {
            return redirect('/admin/login');
        }

        // For simplicity, admin with is_super_admin has all permissions
        if ($request->user('admin')->is_super_admin) {
            return $next($request);
        }

        // In a real app, you'd check for specific permissions
        abort(403, 'Unauthorized action.');
    }
}
