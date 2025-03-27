<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// User Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    
    // Profile Routes
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::put('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update.avatar');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });

    // Direct test route for menu builder
    Route::get('menus-test', [MenuController::class, 'index'])->name('menus.test');

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        
        // User Management
        Route::get('users/data', [UserController::class, 'data'])->name('users.data');
        Route::resource('users', UserController::class);
        
        // Role Management
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{id}', [RoleController::class, 'update'])->name('roles.update');

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('settings/profile', [SettingController::class, 'profile'])->name('settings.profile');
        Route::put('settings/profile', [SettingController::class, 'updateProfile'])->name('settings.profile.update');

        // Post Management
        Route::resource('posts', PostController::class);
        Route::patch('posts/{post}/toggle-status', [PostController::class, 'toggleStatus'])->name('posts.toggle-status');
        Route::resource('categories', CategoryController::class);
        Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        // Pages Routes
        Route::resource('pages', PageController::class);
        Route::post('pages/{page}/toggle-status', [PageController::class, 'toggleStatus'])->name('pages.toggle-status');

        // Menu Builder Routes
        Route::get('menus/{menu}/builder', [MenuController::class, 'builder'])->name('menus.builder');
        Route::post('menu-items/reorder', [MenuItemController::class, 'reorder'])->name('menu-items.reorder');
        Route::resource('menus', MenuController::class);
        Route::resource('menu-items', MenuItemController::class)->except(['index', 'create', 'edit', 'show']);
    });
});

// Logo fallback route
Route::get('/img/default-logo', function () {
    $img = '<svg width="200" height="50" xmlns="http://www.w3.org/2000/svg">
        <rect width="100%" height="100%" fill="#3c4b64"/>
        <text x="50%" y="50%" font-family="Arial" font-size="16" fill="white" text-anchor="middle" dominant-baseline="middle">Admin Panel</text>
    </svg>';
    
    return response($img)->header('Content-Type', 'image/svg+xml');
});

// Add a test route for RoleController
Route::get('/role-test', function() {
    return 'Role test route';
})->name('role.test');
