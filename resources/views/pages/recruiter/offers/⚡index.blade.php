<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\JobOffer;

new #[Title('Mes Offres d\'Emploi')] class extends Component {
    public function offers()
    {
        return auth()->user()->recruiterProfile
            ? auth()->user()->recruiterProfile->jobOffers()->latest()->get()
            : collect();
    }
}; ?>

    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl" level="1">Mes Offres d'Emploi</flux:heading>
                <flux:subheading>Gérez vos recrutements en cours et passés</flux:subheading>
            </div>
            <flux:button :href="route('recruiter.offers.create')" variant="primary" icon="plus" wire:navigate>
                Créer une offre
            </flux:button>
        </div>

        <div class="flex flex-col gap-4">
            @forelse ($this->offers() as $offer)
                <flux:card class="flex items-center justify-between p-4">
                    <div class="flex flex-col gap-1">
                        <flux:heading size="lg">{{ $offer->title }}</flux:heading>
                        <div class="flex items-center gap-4 text-sm text-zinc-500">
                            <span class="flex items-center gap-1">
                                <flux:icon.map-pin class="size-4" />
                                {{ $offer->city }}
                            </span>
                            <span class="flex items-center gap-1">
                                <flux:icon.calendar class="size-4" />
                                {{ $offer->created_at->format('d/m/Y') }}
                            </span>
                            <flux:badge size="sm" :variant="$offer->status->value === 'published' ? 'success' : 'neutral'">
                                {{ $offer->status->label() }}
                            </flux:badge>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <flux:button :href="route('recruiter.offers.applications', $offer)" variant="ghost" size="sm" icon="users" wire:navigate>
                            Candidatures
                        </flux:button>
                        <flux:button :href="route('recruiter.offers.edit', $offer)" variant="ghost" size="sm" icon="pencil-square" wire:navigate />
                    </div>
                </flux:card>
            @empty
                <flux:card>
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <flux:icon.briefcase class="size-12 text-zinc-300 mb-4" />
                        <flux:heading>Aucune offre pour le moment</flux:heading>
                        <flux:subheading class="mb-6">Commencez par publier votre première offre d'emploi.</flux:subheading>
                        <flux:button :href="route('recruiter.offers.create')" variant="primary" wire:navigate>Créer une offre</flux:button>
                    </div>
                </flux:card>
            @endforelse
        </div>
    </div>
