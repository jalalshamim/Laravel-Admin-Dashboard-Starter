<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;

// Role Management Routes
Route::get('admin/roles', [RoleController::class, 'index'])->name('admin.roles.index');
Route::get('admin/roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
Route::put('admin/roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update'); 