<?php

declare(strict_types=1);

use App\Http\Controllers\GoogleController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Homepage;
use Illuminate\Support\Facades\Route;

Route::get('/', Homepage::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', Dashboard::class)->name('dashboard');
});

Route::middleware(['guest'])->group(function () {
    Route::view('/login', 'livewire.auth.login')->name('auth.login');
    Route::get('/auth/redirect', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('/auth/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

require __DIR__.'/settings.php';
