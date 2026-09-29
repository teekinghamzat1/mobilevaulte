<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\SecurityQuestionController;
use App\Http\Controllers\SuperAdmin\CurrencyController;

Route::middleware(['isadmin', 'issuperadmin', '2fa'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/', [SuperAdminController::class, 'dashboard'])->name('home');
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
    Route::get('/users/{id}', [SuperAdminController::class, 'manageUser'])->name('users.manage');

    // Security Question Management
    Route::post('/users/{id}/security-question', [SecurityQuestionController::class, 'update'])->name('users.security.update');

    // Multiple / Account Currency Management
    Route::post('/users/{id}/currency/set', [CurrencyController::class, 'setCurrency'])->name('users.currency.set');
    Route::post('/users/{id}/currency/reset', [CurrencyController::class, 'resetCurrency'])->name('users.currency.reset');
    Route::post('/users/{id}/currencies/assign', [CurrencyController::class, 'assign'])->name('users.currency.assign');
    Route::post('/users/{id}/currencies/remove', [CurrencyController::class, 'remove'])->name('users.currency.remove');
    Route::post('/users/{id}/currencies/balance', [CurrencyController::class, 'updateBalance'])->name('users.currency.balance');
});
