<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dashboard Candidat')] class extends Component {
    public int $completion = 70;
    public bool $is_profile_complete = false;

    // Hardcoded data for UI scaffolding
}; ?>

<div class="flex flex-col gap-8 pb-12">
    {{-- Header --}}
    <div>
        <flux:heading size="xl" level="1">Tableau de bord</flux:heading>
        <flux:subheading>Bienvenue sur votre espace MatchRH, Jean !</flux:subheading>
    </div>

    {{-- Zone 1 — Barre de complétion du profil --}}
    @if ($completion < 100)
        <flux:card class="bg-amber-50 dark:bg-amber-900/10 border-amber-200 dark:border-amber-900/30 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2 flex-1">
                    <flux:heading size="md" class="text-amber-900 dark:text-amber-200 flex items-center gap-2">
                        <flux:icon.exclamation-circle class="size-5" />
                        Votre profil est complété à {{ $completion }}%
                    </flux:heading>
                    <flux:text class="text-amber-800/80 dark:text-amber-300/60">Ajoutez vos compétences pour apparaître dans plus d'offres et voir votre score de compatibilité.</flux:text>

                    <div class="w-full bg-amber-200 dark:bg-amber-900/50 rounded-full h-2.5 mt-4">
                        <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $completion }}%"></div>
                    </div>
                </div>
                <flux:button variant="primary" :href="route('candidate.onboarding')" class="bg-amber-600 hover:bg-amber-700 text-white border-none">
                    Compléter mon profil
                </flux:button>
            </div>
        </flux:card>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Zone 2 — Offres recommandées --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">Offres recommandées</flux:heading>
                <flux:link :href="route('candidate.offers.index')" size="sm">Voir toutes les offres</flux:link>
            </div>

            <div class="space-y-4">
                {{-- Offre 1 --}}
                <flux:card class="p-6 hover:border-emerald-500/50 transition-colors">
                    <div class="flex justify-between items-start gap-4">
                        <div class="space-y-1">
                            <flux:heading size="md">Développeur Laravel Senior</flux:heading>
                            <flux:text  class="flex items-center gap-2">
                                <flux:icon.building-office class="size-4" /> TechCorp · Douala
                            </flux:text>
                            <div class="flex gap-2 mt-4">
                                <flux:badge size="sm" variant="outline">Temps plein</flux:badge>
                                <flux:badge size="sm" variant="outline">Hybride</flux:badge>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <flux:text size="xs"  class="uppercase tracking-widest font-bold">Compatibilité</flux:text>
                            @if (!$is_profile_complete)
                                <div class="mt-1 flex flex-col items-end">
                                    <div class="h-8 w-16 bg-zinc-200 dark:bg-zinc-800 rounded blur-sm"></div>
                                    <flux:text size="xs" color="amber" class="mt-1">Profil incomplet</flux:text>
                                </div>
                            @else
                                <flux:heading size="xl" class="text-emerald-500">92%</flux:heading>
                            @endif
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <flux:button size="sm" variant="ghost" icon-trailing="chevron-right" :href="route('candidate.offers.show', ['offer' => 'id-1'])">Voir l'offre</flux:button>
                    </div>
                </flux:card>

                {{-- Offre 2 --}}
                <flux:card class="p-6 hover:border-emerald-500/50 transition-colors">
                    <div class="flex justify-between items-start gap-4">
                        <div class="space-y-1">
                            <flux:heading size="md">Comptable Senior</flux:heading>
                            <flux:text  class="flex items-center gap-2">
                                <flux:icon.building-office class="size-4" /> FinGroup · Yaoundé
                            </flux:text>
                            <div class="flex gap-2 mt-4">
                                <flux:badge size="sm" variant="outline">Temps plein</flux:badge>
                                <flux:badge size="sm" variant="outline">Sur site</flux:badge>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <flux:text size="xs"  class="uppercase tracking-widest font-bold">Compatibilité</flux:text>
                            @if (!$is_profile_complete)
                                <div class="mt-1 flex flex-col items-end">
                                    <div class="h-8 w-16 bg-zinc-200 dark:bg-zinc-800 rounded blur-sm"></div>
                                    <flux:text size="xs" color="amber" class="mt-1">Profil incomplet</flux:text>
                                </div>
                            @else
                                <flux:heading size="xl" class="text-emerald-500">87%</flux:heading>
                            @endif
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <flux:button size="sm" variant="ghost" icon-trailing="chevron-right">Voir l'offre</flux:button>
                    </div>
                </flux:card>
            </div>
        </div>

        {{-- Zone 3 — Mes candidatures --}}
        <div class="space-y-6">
            <flux:heading size="lg">Mes candidatures</flux:heading>

            <div class="space-y-3">
                <flux:card class="p-4 space-y-4">
                    <div>
                        <flux:text size="sm" class="font-bold">Développeur Laravel Senior</flux:text>
                        <flux:text size="xs" >TechCorp</flux:text>
                    </div>
                    <div class="flex items-center justify-between">
                        <flux:text size="xs" >Envoyée le 01/06/2026</flux:text>
                        <flux:badge size="sm" >En attente</flux:badge>
                    </div>
                </flux:card>

                <flux:card class="p-4 space-y-4">
                    <div>
                        <flux:text size="sm" class="font-bold">Comptable Junior</flux:text>
                        <flux:text size="xs" >BankCM</flux:text>
                    </div>
                    <div class="flex items-center justify-between">
                        <flux:text size="xs" >Envoyée le 28/05/2026</flux:text>
                        <flux:badge size="sm" color="emerald" icon="check">Consultée</flux:badge>
                    </div>
                </flux:card>
            </div>

            <flux:button variant="ghost" size="sm" class="w-full">Voir tout l'historique</flux:button>
        </div>
    </div>
</div>
