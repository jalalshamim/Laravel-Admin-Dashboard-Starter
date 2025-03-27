<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin']);
    }
    
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }
    
    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string|max:1000',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'app_favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'app_email' => 'nullable|email|max:255',
            'app_phone' => 'nullable|string|max:255',
            'app_address' => 'nullable|string|max:500',
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
        ]);
        
        foreach ($validatedData as $key => $value) {
            if ($key === 'app_logo' || $key === 'app_favicon') {
                continue;
            }
            
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        
        // Handle logo upload
        if ($request->hasFile('app_logo')) {
            $logo = $request->file('app_logo');
            $path = $logo->store('logos', 'public');
            
            // Delete old logo if it exists
            $oldLogo = Setting::where('key', 'app_logo')->first();
            if ($oldLogo && Storage::disk('public')->exists($oldLogo->value)) {
                Storage::disk('public')->delete($oldLogo->value);
            }
            
            Setting::updateOrCreate(
                ['key' => 'app_logo'],
                ['value' => $path]
            );
        }
        
        // Handle favicon upload
        if ($request->hasFile('app_favicon')) {
            $favicon = $request->file('app_favicon');
            $path = $favicon->store('logos', 'public');
            
            $oldFavicon = Setting::where('key', 'app_favicon')->first();
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon->value)) {
                Storage::disk('public')->delete($oldFavicon->value);
            }
            
            Setting::updateOrCreate(
                ['key' => 'app_favicon'],
                ['value' => $path]
            );
        }
        
        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
    
    /**
     * Display the profile settings page.
     */
    public function profile()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.settings.profile', compact('admin'));
    }
    
    /**
     * Update the admin profile.
     */
    public function updateProfile(Request $request)
    {
        // Demo mode - disable profile updates
        return redirect()->route('admin.settings.profile')
            ->with('error', 'Profile updates are disabled in demo mode.');
    }
} 