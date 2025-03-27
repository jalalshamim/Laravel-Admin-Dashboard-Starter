<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show');
    }

    public function update(Request $request)
    {
        // Demo mode - disable profile updates
        return redirect()
            ->route('profile.show')
            ->with('error', 'Profile updates are disabled in demo mode.');
    }

    public function updatePassword(Request $request)
    {
        // Demo mode - disable password updates
        return redirect()
            ->route('profile.show')
            ->with('error', 'Password updates are disabled in demo mode.');
    }

    public function updateAvatar(Request $request)
    {
        // Demo mode - disable avatar updates
        return redirect()
            ->route('profile.show')
            ->with('error', 'Avatar updates are disabled in demo mode.');
    }
} 