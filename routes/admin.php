<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin', 'check_suspension'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::livewire('/', 'pages::admin.dashboard')->name('dashboard');

    // Modération / Signalements
    Route::livewire('/reports', 'pages::admin.reports.index')->name('reports.index');

    // Gestion des Utilisateurs
    Route::livewire('/users', 'pages::admin.users.index')->name('users.index');

    // Gestion des Offres (Globale)
    Route::livewire('/jobs', 'pages::admin.jobs.index')->name('jobs.index');

    // Avis / Témoignages
    Route::livewire('/testimonials', 'pages::admin.testimonials.index')->name('testimonials.index');

    // Communications / Updates
    Route::livewire('/communications', 'pages::admin.communications.index')->name('communications.index');

     // Recrutement Admin (Comme un recruteur)
    Route::prefix('recruitment')->name('recruitment.')->group(function () {
        Route::livewire('/', 'pages::admin.recruitment.index')->name('index');
        Route::livewire('/create', 'pages::admin.recruitment.create')->name('create');
        Route::livewire('/{offer}/edit', 'pages::admin.recruitment.edit')->name('edit');
        Route::livewire('/{offer}/applications', 'pages::admin.recruitment.applications')->name('applications');
        Route::livewire('/{offer}/applications/{application}', 'pages::admin.recruitment.application-detail')->name('application-detail');
    });


    Route::livewire('/testimonials', 'pages::admin.testimonials.index')
    ->name('testimonials.index');

Route::livewire('/communications', 'pages::admin.communications.index')
    ->name('communications.index');

    // Paramètres
    Route::livewire('/settings', 'pages::admin.settings')->name('settings.index');
});
