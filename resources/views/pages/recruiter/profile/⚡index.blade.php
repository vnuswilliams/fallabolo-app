<?php

use App\Models\RecruiterProfile;
use App\Services\GeoService;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Profil Entreprise')] class extends Component {
    public string $company_name = '';
    public string $company_sector = '';
    public string $phone = '';    
    public string $country = 'Cameroon';
    public ?string $region = null;
    public ?string $city = null;

    public function mount(): void
    {
        $profile = Auth::user()->recruiterProfile;

        if ($profile) {
            $this->company_name = $profile->company_name;
            $this->company_sector = $profile->company_sector ?? '';
            $this->phone = $profile->phone ?? '';
            $this->region = $profile->region ?? '';
            $this->city = $profile->city ?? '';
            $this->country = $profile->country ?? 'Cameroon';
        }
        $geo = app(GeoService::class);
        $this->availableCountries = $geo->getCountries();
        $this->availableRegions   = $geo->getStatesByCountry($this->country);
        
        if ($this->region) {
            $this->availableCities = $geo->getCitiesByState($this->country, $this->region);
        } else {
            $this->availableCities = $geo->getCitiesByCountry($this->country);
        }
    }
    public array $availableCountries = [];
    public array $availableRegions = [];
    public array $availableCities = [];


    public function updatedCountry($value)
    {
        $geo = app(GeoService::class);
        $this->region = '';
        $this->city   = '';
        $this->availableRegions = $geo->getStatesByCountry($value);
        $this->availableCities  = $geo->getCitiesByCountry($value);
    }

    public function updatedRegion($value)
    {
        $this->city = '';
        $this->availableCities = app(GeoService::class)
            ->getCitiesByState($this->country, $value);
    }
    public function save(): void
    {
        $this->validate([
            'company_name' => 'required|string|max:255',
            'company_sector' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $profile = Auth::user()->recruiterProfile ?? new RecruiterProfile(['user_id' => Auth::id()]);

        $profile->fill([
            'company_name' => $this->company_name,
            'company_sector' => $this->company_sector,
            'phone' => $this->phone,
            'city' => $this->city,
            'region' => $this->region,
            'country' => $this->country,
        ]);

        $profile->save();

        Flux::toast(variant: 'success', text: __('Profil entreprise mis à jour.'));
    }
}; ?>

    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <flux:heading size="xl" level="1">Profil Entreprise</flux:heading>
            <flux:subheading>Gérez les informations de votre entreprise pour attirer les meilleurs talents.</flux:subheading>
        </div>

        <flux:card>
            <form wire:submit="save" class="space-y-6">
                <flux:input wire:model="company_name" :label="__('Nom de l\'entreprise')" required />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input wire:model="company_sector" :label="__('Secteur d\'activité')" placeholder="Ex: Technologie, Santé..." />
                    <flux:input wire:model="phone" :label="__('Téléphone de contact')" />
                </div>

                <flux:select wire:model.live="country" :label="__('Pays')">
                    @foreach($availableCountries as $c)
                        <flux:select.option value="{{ $c }}">{{ $c }}</flux:select.option>
                    @endforeach
                </flux:select>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:select wire:model.live="region" :label="__('Région')">
                        @foreach($availableRegions as $r)
                            <flux:select.option value="{{ $r }}">{{ $r }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:select wire:model="city" :label="__('Ville du siège')">
                        @foreach($availableCities as $c)
                            <flux:select.option value="{{ $c }}">{{ $c }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-4">
                    <flux:button variant="ghost" :href="route('recruiter.dashboard')" wire:navigate>Annuler</flux:button>
                    <flux:button type="submit" variant="primary">Enregistrer les modifications</flux:button>
                </div>
            </form>
        </flux:card>
    </div>
