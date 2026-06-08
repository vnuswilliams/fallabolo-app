<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::livewire('/', 'pages::admin.dashboard')->name('dashboard');

    /*

    // Offres d'emploi
        Route::livewire('offers', 'pages::admin.offers.index')->name('offers.index');
        Route::livewire('{offer}', 'pages::admin.offers.show')->name('offers.show');

    // Candidatures
    Route::prefix('applications')->name('applications.')->group(function () {
        Route::livewire('/', 'pages::admin.applications.index')->name('index');
        Route::livewire('{application}', 'pages::admin.applications.show')->name('show');
    });

    // Profil candidat
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::livewire('/', 'pages::admin.profile.index')->name('index');
        Route::livewire('edit', 'pages::admin.profile.edit')->name('edit');
        Route::livewire('skills', 'pages::admin.profile.skills')->name('skills');
    });

    // Paramètres
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::livewire('/', 'pages::admin.settings')->name('index');
    });*/
});
