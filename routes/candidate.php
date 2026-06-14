<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:candidate', 'check_suspension'])->prefix('candidate')->name('candidate.')->group(function () {
    // Onboarding
    Route::livewire('onboarding', 'pages::candidate.onboarding')->name('onboarding');

    // Dashboard
    Route::livewire('/', 'pages::candidate.dashboard')->name('dashboard');

    // Offres d'emploi
        Route::livewire('offers', 'pages::candidate.offers.index')->name('offers.index');
        Route::livewire('{offer}', 'pages::candidate.offers.show')->name('offers.show');

    // Candidatures
        Route::livewire('/applications', 'pages::candidate.applications.index')->name('applications.index');
        Route::livewire('{application}', 'pages::candidate.applications.show')->name('applications.show');

    // Profil candidat
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::livewire('/', 'pages::candidate.profile.index')->name('index');
        Route::livewire('edit', 'pages::candidate.profile.edit')->name('edit');
        Route::livewire('skills', 'pages::candidate.profile.skills')->name('skills');
    });

    // Paramètres
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::livewire('/', 'pages::candidate.settings')->name('index');
    });


    // Avis
    Route::livewire('/testimonial', 'pages::candidate.testimonial')->name('testimonial');
});
