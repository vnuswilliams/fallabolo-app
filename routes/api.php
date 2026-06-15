<?php

use App\Services\GeoService;
use Illuminate\Support\Facades\Route;
// routes/api.php
Route::get('/geo/countries', fn () => app(GeoService::class)->getCountries());
Route::get('/geo/states/{country}', fn ($country) => app(GeoService::class)->getStatesByCountry($country));
Route::get('/geo/cities/{country}', fn ($country) => app(GeoService::class)->getCitiesByCountry($country));
Route::get('/geo/cities/{country}/{state}', fn ($country, $state) => app(GeoService::class)->getCitiesByState($country, $state));