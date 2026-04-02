<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Management Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:create users');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('permission:create users');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:edit users');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:edit users');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:delete users');

    // Permission Management Routes
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:view permissions');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:create permissions');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:create permissions');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:delete permissions');

    // Role Management Routes
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index')->middleware('permission:view roles');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create')->middleware('permission:create roles');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:create roles');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show')->middleware('permission:view roles');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:edit roles');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update')->middleware('permission:edit roles');
    Route::post('/roles/{role}/toggle-block', [RoleController::class, 'toggleBlock'])->name('roles.toggleBlock')->middleware('permission:edit roles');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:delete roles');
});

require __DIR__.'/auth.php';
