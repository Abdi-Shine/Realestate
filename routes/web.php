<?php

use App\Http\Controllers\ProfileController;
use GuzzleHttp\Middleware;
use App\Http\Middleware\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;

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
});

require __DIR__.'/auth.php';
//admin Group Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {

Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])
    ->name('admin.dashboard');
    //logout route
Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])
    ->name('admin.logout');
    //admin.phofile
Route::get('/admin/profile', [AdminController::class, 'Adminprofile'])
    ->name('admin.profile');

Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])
    ->name('admin.profile.store');

Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])
    ->name('admin.change.password');

Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])
    ->name('admin.update.password');

//admin/login 
}); 

//Agent Middleware

Route::middleware(['auth', 'role:agent'])->group(function () {
Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])
    ->name('agent.dashboard');
});
//admin/login
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])
    ->name('admin.login');

// Temporary route to clear cache on cPanel
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
});