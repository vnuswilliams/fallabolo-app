<?php

use Illuminate\Support\Facades\Route;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

Route::redirect('/', 'welcome')
 ->middleware(\App\Http\Middleware\RedirectRegisteredUsers::class)
 ->name('home');

Route::view('/welcome', 'welcome')->name('landing');
Route::view('/admin-register', 'pages.auth.admin-register')->name('admin.register');
Route::livewire('/suspended', 'pages.suspended')->name('suspended');

Route::middleware(['auth', 'verified', 'check_suspension', 'role_redirect'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});
Route::get('/legal/{slug}', function (string $slug) {
    $path = base_path('legals/' . $slug . '.md');

    if (!File::exists($path)) {
        abort(404);
    }

    $content = File::get($path);
    $html = Str::markdown($content);
    $title = strtoupper($slug);

    return view('legal', [
        'content' => $html,
        'title' => $title,
    ]);
})->name('legal.show');
require __DIR__.'/recruiter.php';
require __DIR__.'/admin.php';
require __DIR__.'/candidate.php';
require __DIR__.'/settings.php';
require __DIR__.'/api.php';
