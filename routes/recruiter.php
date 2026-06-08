<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:recruiter', 'check_suspension'])->prefix('recruiter')->name('recruiter.')->group(function () {
    // Onboarding
    Route::livewire('onboarding', 'pages::recruiter.onboarding')->name('onboarding');

    // Dashboard
    Route::livewire('/', 'pages::recruiter.dashboard')->name('dashboard');

    // Offres d'emploi
    Route::prefix('offers')->name('offers.')->group(function () {
        Route::livewire('/', 'pages::recruiter.offers.index')->name('index');
        Route::livewire('create', 'pages::recruiter.offers.create')->name('create');
        Route::livewire('{offer}/edit', 'pages::recruiter.offers.edit')->name('edit');
        Route::livewire('{offer}/applications', 'pages::recruiter.offers.applications')->name('applications');
        Route::livewire('{offer}/applications/{application}', 'pages::recruiter.offers.application-detail')->name('application-detail');
    });

    // Profil recruteur
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::livewire('/', 'pages::recruiter.profile.index')->name('index');
        Route::livewire('edit', 'pages::recruiter.profile.edit')->name('edit');
    });

    // Paramètres
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::livewire('/', 'pages::recruiter.settings')->name('index');
    });
});
