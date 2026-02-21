<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvitationsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\TemplatesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('index');
Route::get('/captcha/refresh', function() {
    return response()->json(['captcha' => captcha_img('math')]);
})->name('captcha.refresh');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/auth', [AuthController::class, 'auth'])->name('login.auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/users', [UsersController::class, 'index'])->name('users.index');
Route::post('/users/add', [UsersController::class, 'store'])->name('users.add');
Route::post('/users/update', [UsersController::class, 'update'])->name('users.update');
Route::delete('/users/{id}/delete', [UsersController::class, 'destroy'])->name('users.delete');
Route::get('/users/temp', [UsersController::class, 'temp'])->name('users.temp');

Route::get('/templates', [TemplatesController::class, 'index'])->name('templates.index');
Route::post('/templates/add', [TemplatesController::class, 'store'])->name('templates.add');
Route::post('/templates/update', [TemplatesController::class, 'update'])->name('templates.update');
Route::delete('/templates/{id}/delete', [TemplatesController::class, 'destroy'])->name('templates.delete');
Route::get('/templates/temp', [TemplatesController::class, 'temp'])->name('templates.temp');

Route::get('/invitations', [InvitationsController::class, 'index'])->name('invitations.index');
Route::post('/invitations/add', [InvitationsController::class, 'store'])->name('invitations.add');
Route::post('/invitations/update', [InvitationsController::class, 'update'])->name('invitations.update');
Route::delete('/invitations/{id}/delete', [InvitationsController::class, 'destroy'])->name('invitations.delete');
Route::get('/invitations/lookup', [InvitationsController::class, 'lookup'])->name('invitations.lookup');
Route::get('/invitations/stats', [InvitationsController::class, 'stats'])->name('invitations.stats');
Route::get('/invitations/temp', [InvitationsController::class, 'temp'])->name('invitations.temp');

Route::get('/payments', [PaymentsController::class, 'index'])->name('payments.index');
Route::get('/payments/add', [PaymentsController::class, 'store'])->name('payments.add');
Route::get('/payments/update', [PaymentsController::class, 'update'])->name('payments.update');
Route::get('/payments/{id}/delete', [PaymentsController::class, 'destroy'])->name('payments.delete');
Route::get('/payments/stats', [PaymentsController::class, 'stats'])->name('payments.stats');
Route::get('/payments/temp', [PaymentsController::class, 'temp'])->name('payments.temp');
