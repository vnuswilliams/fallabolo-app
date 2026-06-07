<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\RecruiterProfile;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;

new #[Title('Profil Entreprise')] class extends Component {
    public string $company_name = '';
    public string $company_sector = '';
    public string $phone = '';
    public string $city = '';
    public string $country = 'Cameroun';

    public function mount(): void
    {
        $profile = Auth::user()->recruiterProfile;

        if ($profile) {
            $this->company_name = $profile->company_name;
            $this->company_sector = $profile->company_sector ?? '';
            $this->phone = $profile->phone ?? '';
            $this->city = $profile->city ?? '';
            $this->country = $profile->country ?? 'Cameroun';
        }
    }

    public function save(): void
    {
        $this->validate([
            'company_name' => 'required|string|max:255',
            'company_sector' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $profile = Auth::user()->recruiterProfile ?? new RecruiterProfile(['user_id' => Auth::id()]);

        $profile->fill([
            'company_name' => $this->company_name,
            'company_sector' => $this->company_sector,
            'phone' => $this->phone,
            'city' => $this->city,
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input wire:model="city" :label="__('Ville du siège')" />
                    <flux:input wire:model="country" :label="__('Pays')" />
                </div>

                <div class="flex items-center justify-end gap-2 pt-4">
                    <flux:button variant="ghost" :href="route('recruiter.dashboard')" wire:navigate>Annuler</flux:button>
                    <flux:button type="submit" variant="primary">Enregistrer les modifications</flux:button>
                </div>
            </form>
        </flux:card>
    </div>
