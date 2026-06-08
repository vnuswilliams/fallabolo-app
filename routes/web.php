<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login')->name('home');
Route::view('/admin-register', 'pages.auth.admin-register')->name('admin.register');
Route::livewire('/suspended', 'pages.suspended')->name('suspended');

Route::middleware(['auth', 'verified', 'check_suspension', 'role_redirect'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/recruiter.php';
require __DIR__.'/admin.php';
require __DIR__.'/candidate.php';
require __DIR__.'/settings.php';
