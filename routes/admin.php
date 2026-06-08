<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin', 'check_suspension'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::livewire('/', 'pages::admin.dashboard')->name('dashboard');

    // Modération / Signalements
    Route::livewire('/reports', 'pages::admin.reports.index')->name('reports.index');

    // Gestion des Utilisateurs
    Route::livewire('/users', 'pages::admin.users.index')->name('users.index');

    // Gestion des Offres
    Route::livewire('/offers', 'pages::admin.offers.index')->name('offers.index');

    // Paramètres
    Route::livewire('/settings', 'pages::admin.settings')->name('settings.index');
});
