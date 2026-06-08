<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Candidats qualifiés')] class extends Component {
    // Hardcoded data for UI scaffolding
}; ?>

<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <flux:link :href="route('recruiter.offers.index')" icon="chevron-left" variant="ghost" class="mb-4">Retour aux offres</flux:link>
            <flux:heading size="xl">Développeur Laravel Senior</flux:heading>
            <flux:subheading>12 candidats qualifiés classés par score de compatibilité</flux:subheading>
        </div>
        <div class="flex gap-2">
            <flux:button icon="printer" variant="ghost" size="sm" />
            <flux:button icon="arrow-down-tray" variant="ghost" size="sm" />
        </div>
    </div>

    <div class="space-y-4">
        @foreach ([
            ['id' => 1, 'name' => 'Jean Ekotto', 'score' => 94, 'assets' => '3/5', 'skills' => 2, 'city' => 'Douala', 'status' => 'Nouveau'],
            ['id' => 2, 'name' => 'Marie Mballa', 'score' => 89, 'assets' => '2/5', 'skills' => 1, 'city' => 'Yaoundé', 'status' => 'Nouveau'],
            ['id' => 3, 'name' => 'Alain Nkodo', 'score' => 85, 'assets' => '4/5', 'skills' => 3, 'city' => 'Douala', 'status' => 'Consulté'],
            ['id' => 4, 'name' => 'Sophie Biyong', 'score' => 79, 'assets' => '1/5', 'skills' => 0, 'city' => 'Douala', 'status' => 'Consulté'],
            ['id' => 5, 'name' => 'Paul Essomba', 'score' => 71, 'assets' => '2/5', 'skills' => 1, 'city' => 'Yaoundé', 'status' => 'Nouveau'],
        ] as $candidate)
            <flux:card class="p-4 hover:border-emerald-500/50 transition-colors cursor-pointer group"
                onclick="window.location.href='/recruiter/offers/1/applications/{{ $candidate['id'] }}'">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center font-bold text-lg text-zinc-500">
                            {{ substr($candidate['name'], 0, 1) }}{{ substr(explode(' ', $candidate['name'])[1] ?? '', 0, 1) }}
                        </div>
                        <div>
                            <flux:heading size="md" class="group-hover:text-emerald-500 transition-colors">{{ $candidate['name'] }}</flux:heading>
                            <div class="flex flex-wrap gap-x-4 gap-y-1 mt-1">
                                <flux:text size="xs"  class="flex items-center gap-1">
                                    <flux:icon.map-pin class="size-3" /> {{ $candidate['city'] }}
                                </flux:text>
                                <flux:text size="xs"  class="flex items-center gap-1">
                                    <flux:icon.star class="size-3" /> Atouts: {{ $candidate['assets'] }}
                                </flux:text>
                                <flux:text size="xs"  class="flex items-center gap-1">
                                    <flux:icon.cpu-chip class="size-3" /> Compétences supp: {{ $candidate['skills'] }}
                                </flux:text>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="text-right">
                            <flux:text size="xs"  class="uppercase tracking-wider font-semibold">Compatibilité</flux:text>
                            <div class="flex items-center gap-2">
                                <flux:heading size="lg" class="text-emerald-500">{{ $candidate['score'] }}%</flux:heading>
                            </div>
                        </div>
                        <flux:button variant="ghost" icon="chevron-right" />
                    </div>
                </div>
            </flux:card>
        @endforeach
    </div>

    <div class="flex justify-center pt-4">
        <flux:button variant="ghost" size="sm">Charger plus de candidats</flux:button>
    </div>
</div>
