<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles and users.
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('name')->paginate(10);
        $roles = Role::where('guard_name', 'web')->get();
        
        return view('admin.roles.index', compact('users', 'roles'));
    }

    /**
     * Show the form for editing a user role.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::where('guard_name', 'web')->get();
        
        return view('admin.roles.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user role.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($id);
        
        // Remove all current roles and assign the new one
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'User role updated successfully.');
    }
} 