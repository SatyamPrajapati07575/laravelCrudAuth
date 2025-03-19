<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');


Route::middleware(['auth'])->group(function () {
    // User listing
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    
    // Edit user
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    
    // Update user
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    
    // Delete user
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});