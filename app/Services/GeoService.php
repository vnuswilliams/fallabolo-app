<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeoService
{
    const BASE_URL = 'https://countriesnow.space/api/v0.1';

    public function getCountries(): array
    {
        return Cache::remember('geo.countries', now()->addDays(7), function () {
            $response = Http::get(self::BASE_URL . '/countries/positions');
            return collect($response->json('data', []))
                ->sortBy('name')
                ->pluck('name')
                ->values()
                ->toArray();
        });
    }

    public function getStatesByCountry(?string $country = 'Cameroon'): array
    {
        $key = 'geo.states.' . str($country)->slug();
        return Cache::remember($key, now()->addDays(7), function () use ($country) {
            $response = Http::post(self::BASE_URL . '/countries/states', [
                'country' => $country,
            ]);
            // Retourne [{name: "Centre", state_code: "CE"}, ...]
            return collect($response->json('data.states', []))
                ->pluck('name')
                ->values()
                ->toArray();
        });
    }

    public function getCitiesByCountry(?string $country = 'Cameroon'): array
    {
        $key = 'geo.cities.' . str($country)->slug();
        return Cache::remember($key, now()->addDays(7), function () use ($country) {
            $response = Http::post(self::BASE_URL . '/countries/cities', [
                'country' => $country,
            ]);
            return $response->json('data', []);
        });
    }

    public function getCitiesByState(?string $country = 'Cameroon', ?string $state = 'Littoral'): array
{
    $key = 'geo.cities.' . str($country)->slug() . '.' . str($state)->slug();
    
    return Cache::remember($key, now()->addDays(7), function () use ($country, $state) {
        $response = Http::post(self::BASE_URL . '/countries/state/cities', [
            'country' => $country,
            'state'   => $state,
        ]);
        return $response->json('data', []);
    });
}
}