<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Offres disponibles')] class extends Component {
    public bool $is_profile_complete = true;

    // Hardcoded data for UI scaffolding
}; ?>

<div class="max-w-5xl mx-auto space-y-8 pb-12">
    <div>
        <flux:heading size="xl">Offres d'emploi</flux:heading>
        <flux:subheading>Découvrez les opportunités qui correspondent à votre profil.</flux:subheading>
    </div>

    {{-- Filtres --}}
    <flux:card class="p-4 flex flex-wrap gap-4 items-center border-zinc-200 dark:border-zinc-800">
        <flux:input placeholder="Rechercher un poste..." class="flex-1 min-w-[200px]" icon="magnifying-glass" />
        <flux:select placeholder="Ville" class="w-40">
            <flux:select.option>Douala</flux:select.option>
            <flux:select.option>Yaoundé</flux:select.option>
        </flux:select>
        <flux:select placeholder="Secteur" class="w-48">
            <flux:select.option>Informatique</flux:select.option>
            <flux:select.option>Finance</flux:select.option>
        </flux:select>
        <flux:button variant="primary">Filtrer</flux:button>
    </flux:card>

    <div class="space-y-4">
        @foreach ([
            ['id' => 1, 'title' => 'Développeur Laravel Senior', 'company' => 'TechCorp', 'city' => 'Douala', 'score' => 92, 'date' => '02 juin 2026'],
            ['id' => 2, 'title' => 'Développeur Full Stack', 'company' => 'StartupCM', 'city' => 'Douala', 'score' => 88, 'date' => '01 juin 2026'],
            ['id' => 3, 'title' => 'Intégrateur Web', 'company' => 'AgenceDig', 'city' => 'Yaoundé', 'score' => 81, 'date' => '30 mai 2026'],
            ['id' => 4, 'title' => 'Comptable Senior', 'company' => 'FinGroup', 'city' => 'Yaoundé', 'score' => 75, 'date' => '28 mai 2026'],
        ] as $offer)
            <flux:card class="p-6 hover:border-emerald-500/50 transition-colors group">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="flex gap-4">
                        <div class="w-14 h-14 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0 border border-zinc-200 dark:border-zinc-700">
                            <flux:icon.building-office class="size-6 text-zinc-400" />
                        </div>
                        <div class="space-y-1">
                            <flux:heading size="md" class="group-hover:text-emerald-500 transition-colors">{{ $offer['title'] }}</flux:heading>
                            <flux:text  class="flex items-center gap-2">
                                {{ $offer['company'] }} · {{ $offer['city'] }}
                            </flux:text>
                            <flux:text size="xs" >Publiée le {{ $offer['date'] }}</flux:text>
                        </div>
                    </div>

                    <div class="flex items-center gap-8 self-end sm:self-center">
                        <div class="text-right">
                            <flux:text size="xs"  class="uppercase tracking-widest font-bold">Compatibilité</flux:text>
                            @if (!$is_profile_complete)
                                <div class="mt-1 flex flex-col items-end">
                                    <div class="h-8 w-16 bg-zinc-200 dark:bg-zinc-800 rounded blur-sm"></div>
                                </div>
                            @else
                                <flux:heading size="lg" class="text-emerald-500">{{ $offer['score'] }}%</flux:heading>
                            @endif
                        </div>
                        <flux:button variant="ghost" icon-trailing="chevron-right" :href="route('candidate.offers.show', ['offer' => $offer['id']])" wire:navigate>Voir l'offre</flux:button>
                    </div>
                </div>
            </flux:card>
        @endforeach
    </div>

    <div class="flex justify-center pt-8">
        <flux:pagination />
    </div>
</div>
