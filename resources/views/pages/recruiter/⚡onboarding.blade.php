<?php

use Livewire\Component;
use App\Models\RecruiterProfile;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

new #[Title('Onboarding Recruteur')] class extends Component {
    public string $company_name = '';
    public string $company_sector = '';
    public string $phone = '';
    public string $city = '';
    public string $country = 'Cameroun';

    public function mount()
    {
        if (Auth::user()->recruiterProfile) {
            return redirect()->route('recruiter.dashboard');
        }
    }

    public function save()
    {
        // UI Scaffolding - we simulate the behavior
        // In a real app, we would create the profile here

        Auth::user()->recruiterProfile()->create([
            'company_name' => $this->company_name,
            'company_sector' => $this->company_sector,
            'phone' => $this->phone,
            'city' => $this->city,
            'country' => $this->country,
        ]);

        return redirect()->route('recruiter.dashboard');
    }
};
?>

<div class="flex flex-col items-center justify-center min-h-screen p-6 bg-zinc-950">
    <div class="w-full max-w-md space-y-8">
        <div class="text-center">
            <div class="flex justify-center mb-6">
                 <span class="grid size-12 place-items-center rounded-xl bg-zinc-50 text-zinc-950 font-black text-xl">
                    sq
                </span>
            </div>
            <flux:heading size="xl" class="text-white">Bienvenue sur MatchRH</flux:heading>
            <flux:text  class="mt-2">Complétez votre profil entreprise pour accéder à votre espace recruteur.</flux:text>
        </div>

        <flux:card class="p-6 bg-zinc-900 border-zinc-800">
            <form wire:submit="save" class="space-y-6">
                <flux:field>
                    <flux:label class="text-zinc-300">Nom de l'entreprise</flux:label>
                    <flux:input wire:model="company_name" placeholder="Ex: TechCorp Douala" required
                        class="bg-zinc-800 border-zinc-700 text-white focus:border-emerald-500" />
                </flux:field>

                <flux:field>
                    <flux:label class="text-zinc-300">Secteur d'activité</flux:label>
                    <flux:select wire:model="company_sector" placeholder="Choisir un secteur"
                        class="bg-zinc-800 border-zinc-700 text-white focus:border-emerald-500">
                        <flux:select.option value="Informatique">Informatique & Télécoms</flux:select.option>
                        <flux:select.option value="Finance">Banque & Finance</flux:select.option>
                        <flux:select.option value="Retail">Commerce & Distribution</flux:select.option>
                        <flux:select.option value="Industrie">Industrie</flux:select.option>
                        <flux:select.option value="Services">Services</flux:select.option>
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:label class="text-zinc-300">Téléphone de contact</flux:label>
                    <flux:input wire:model="phone" type="tel" placeholder="Ex: 690 00 00 00"
                        class="bg-zinc-800 border-zinc-700 text-white focus:border-emerald-500" />
                </flux:field>

                <div class="grid grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label class="text-zinc-300">Ville</flux:label>
                        <flux:select wire:model="city" class="bg-zinc-800 border-zinc-700 text-white focus:border-emerald-500">
                            <flux:select.option value="Douala">Douala</flux:select.option>
                            <flux:select.option value="Yaoundé">Yaoundé</flux:select.option>
                            <flux:select.option value="Autre">Autre</flux:select.option>
                        </flux:select>
                    </flux:field>

                    <flux:field>
                        <flux:label class="text-zinc-300">Pays</flux:label>
                        <flux:input wire:model="country" disabled
                            class="bg-zinc-900 border-zinc-700 text-zinc-500" />
                    </flux:field>
                </div>

                <div class="pt-4">
                    <flux:button type="submit" variant="primary" class="w-full bg-emerald-500 hover:bg-emerald-600 text-zinc-950 font-bold py-3 rounded-xl transition-all">
                        Accéder à mon espace
                    </flux:button>
                </div>
            </form>
        </flux:card>

        <p class="text-center text-xs text-zinc-500 mt-8">
            En continuant, vous acceptez nos conditions d'utilisation et notre politique de confidentialité.
        </p>
    </div>
</div>
