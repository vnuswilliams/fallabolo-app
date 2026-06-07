<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Auth;

new #[Title('Mon Profil')] class extends Component {
    public function candidateProfile()
    {
        return Auth::user()->candidateProfile;
    }
}; ?>

<x-layouts::app>
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <flux:heading size="xl" level="1">Mon Profil</flux:heading>
                <flux:subheading>Informations personnelles et professionnelles sur MatchRH.</flux:subheading>
            </div>
            <flux:button :href="route('candidate.profile.edit')" variant="primary" icon="pencil-square" wire:navigate>
                Modifier le profil
            </flux:button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 flex flex-col gap-6">
                <!-- Informations de base -->
                <flux:card>
                    <flux:heading size="lg" class="mb-4">Informations de base</flux:heading>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <flux:label class="text-zinc-500">Nom complet</flux:label>
                            <flux:text font-medium>{{ Auth::user()->name }}</flux:text>
                        </div>
                        <div>
                            <flux:label class="text-zinc-500">Email</flux:label>
                            <flux:text font-medium>{{ Auth::user()->email }}</flux:text>
                        </div>
                        <div>
                            <flux:label class="text-zinc-500">Téléphone</flux:label>
                            <flux:text font-medium>{{ $this->candidateProfile()?->phone ?? 'Non renseigné' }}</flux:text>
                        </div>
                        <div>
                            <flux:label class="text-zinc-500">Localisation</flux:label>
                            <flux:text font-medium>{{ $this->candidateProfile()?->city ?? 'Non renseigné' }}, {{ $this->candidateProfile()?->country ?? 'Cameroun' }}</flux:text>
                        </div>
                    </div>
                </flux:card>

                <!-- Parcours -->
                <flux:card>
                    <flux:heading size="lg" class="mb-4">Parcours & Formation</flux:heading>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <flux:label class="text-zinc-500">Niveau d'études</flux:label>
                            <flux:text font-medium>{{ $this->candidateProfile()?->education_level?->label() ?? 'Non renseigné' }}</flux:text>
                        </div>
                        <div>
                            <flux:label class="text-zinc-500">Domaine d'études</flux:label>
                            <flux:text font-medium>{{ $this->candidateProfile()?->education_field ?? 'Non renseigné' }}</flux:text>
                        </div>
                        <div>
                            <flux:label class="text-zinc-500">Expérience</flux:label>
                            <flux:text font-medium>{{ $this->candidateProfile()?->experience_tier?->label() ?? 'Non renseigné' }}</flux:text>
                        </div>
                        <div>
                            <flux:label class="text-zinc-500">Disponibilité</flux:label>
                            <flux:text font-medium>{{ $this->candidateProfile()?->availability?->label() ?? 'Non renseigné' }}</flux:text>
                        </div>
                    </div>
                </flux:card>
            </div>

            <div class="lg:col-span-1 flex flex-col gap-6">
                <flux:card>
                    <flux:heading size="lg" class="mb-4">Actions</flux:heading>
                    <flux:navlist variant="outline">
                        <flux:navlist.item :href="route('candidate.profile.skills')" icon="bolt" wire:navigate>
                            Gérer mes compétences
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('candidate.applications.index')" icon="document-text" wire:navigate>
                            Mes candidatures
                        </flux:navlist.item>
                    </flux:navlist>
                </flux:card>

                @if($this->candidateProfile()?->cv_path)
                    <flux:card class="bg-zinc-50 dark:bg-zinc-900 border-dashed">
                        <div class="flex items-center gap-3">
                            <flux:icon.document-text class="text-zinc-400" />
                            <div class="flex-1 min-w-0">
                                <flux:heading size="sm" class="truncate">CV téléchargé</flux:heading>
                                <flux:subheading class="truncate">Format PDF</flux:subheading>
                            </div>
                        </div>
                    </flux:card>
                @endif
            </div>
        </div>
    </div>
</x-layouts::app>
