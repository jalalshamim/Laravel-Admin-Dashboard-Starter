<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('Admin login attempt', [
            'email' => $credentials['email'],
            'remember' => $request->filled('remember')
        ]);

        // Check if admin exists
        $admin = \App\Models\Admin::where('email', $credentials['email'])->first();
        if (!$admin) {
            Log::warning('Admin not found with email: ' . $credentials['email']);
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
        }

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $admin = Auth::guard('admin')->user();
            $admin->update(['last_login_at' => Carbon::now()]);

            Log::info('Admin logged in successfully', [
                'admin_id' => $admin->id,
                'admin_email' => $admin->email
            ]);

            activity()
                ->causedBy($admin)
                ->log('Admin logged in');

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back, ' . $admin->name);
        }

        Log::warning('Failed login attempt for admin', [
            'email' => $credentials['email']
        ]);

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
    }

    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        activity()
            ->causedBy($admin)
            ->log('Admin logged out');

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'You have been successfully logged out');
    }
}
