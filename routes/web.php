<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\TemplatesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login/auth', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::get('/users/temp', [UsersController::class, 'temp'])->name('users.index');
Route::get('/templates', [TemplatesController::class, 'index']);
Route::get('/invitations', [InvitationsController::class, 'index']);
Route::get('/payments', [PaymentsController::class, 'index'])->name('payments.index');
