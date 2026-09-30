<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\SecurityQuestionController;
use App\Http\Controllers\SuperAdmin\CurrencyController;

// Compatibility redirects & aliases for legacy /superadmin paths
Route::middleware(['isadmin', '2fa'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.security-currencies.dashboard');
    })->name('home');

    Route::get('/dashboard', function () {
        return redirect()->route('admin.security-currencies.dashboard');
    })->name('dashboard');

    Route::get('/users', function () {
        return redirect()->route('admin.security-currencies');
    })->name('users');

    Route::get('/users/{id}', function ($id) {
        return redirect()->route('admin.users.manage', $id);
    })->name('users.manage');

    // Security Question Management (POST fallback)
    Route::post('/users/{id}/security-question', [SecurityQuestionController::class, 'update'])->name('users.security.update');

    // Multiple / Account Currency Management (POST fallbacks)
    Route::post('/users/{id}/currency/set', [CurrencyController::class, 'setCurrency'])->name('users.currency.set');
    Route::post('/users/{id}/currency/reset', [CurrencyController::class, 'resetCurrency'])->name('users.currency.reset');
    Route::post('/users/{id}/currencies/assign', [CurrencyController::class, 'assign'])->name('users.currency.assign');
    Route::post('/users/{id}/currencies/remove', [CurrencyController::class, 'remove'])->name('users.currency.remove');
    Route::post('/users/{id}/currencies/balance', [CurrencyController::class, 'updateBalance'])->name('users.currency.balance');
});

