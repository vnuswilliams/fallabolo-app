<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\JobOffer;
use App\Models\Application;

new #[Title('Dashboard Recruteur')] class extends Component {
public function mount()
    {
        // dd(auth()->user()->getRoleNames());
        // This is where you would normally fetch real data, but we'll use hardcoded values for UI scaffolding
    }
    // We'll use hardcoded data as requested for UI Scaffolding
}; ?>

<div class="flex flex-col gap-8">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl" level="1">Bienvenue, TechCorp !</flux:heading>
            <flux:subheading>Voici l'état de vos recrutements aujourd'hui.</flux:subheading>
        </div>
        <flux:button :href="route('recruiter.offers.create')" variant="primary" icon="plus" wire:navigate>
            Publier une offre
        </flux:button>
    </div>

    {{-- Zone 1: Cartes de synthèse --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <flux:card class="flex flex-col gap-2 p-4 border-zinc-200 dark:border-zinc-800">
            <flux:text size="sm"  class="font-medium uppercase tracking-wider">Offres actives</flux:text>
            <div class="flex items-end justify-between">
                <flux:heading size="xl" class="leading-none">3</flux:heading>
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                    <flux:icon.briefcase class="size-5 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
        </flux:card>

        <flux:card class="flex flex-col gap-2 p-4 border-zinc-200 dark:border-zinc-800">
            <flux:text size="sm"  class="font-medium uppercase tracking-wider">Candidatures non consultées</flux:text>
            <div class="flex items-end justify-between">
                <flux:heading size="xl" class="leading-none">7</flux:heading>
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <flux:icon.envelope class="size-5 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </flux:card>

        <flux:card class="flex flex-col gap-2 p-4 border-zinc-200 dark:border-zinc-800">
            <flux:text size="sm"  class="font-medium uppercase tracking-wider">Nouveaux matchs (24h)</flux:text>
            <div class="flex items-end justify-between">
                <flux:heading size="xl" class="leading-none">4</flux:heading>
                <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                    <flux:icon.sparkles class="size-5 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
        </flux:card>

        <flux:card class="flex flex-col gap-2 p-4 border-zinc-200 dark:border-zinc-800">
            <flux:text size="sm"  class="font-medium uppercase tracking-wider">Offres en brouillon</flux:text>
            <div class="flex items-end justify-between">
                <flux:heading size="xl" class="leading-none">1</flux:heading>
                <div class="p-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg">
                    <flux:icon.document-text class="size-5 text-zinc-600 dark:text-zinc-400" />
                </div>
            </div>
        </flux:card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Zone 2: Mes offres actives (Tableau central) --}}
        <div class="lg:col-span-3 space-y-4">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">Mes offres actives</flux:heading>
                <flux:link :href="route('recruiter.offers.index')" size="sm">Voir toutes les offres</flux:link>
            </div>

                <flux:card class=" overflow-hidden border-zinc-200 dark:border-zinc-800 p-4">

                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Poste</flux:table.column>
                        <flux:table.column class="hidden sm:table-cell">Publiée le</flux:table.column>
                        <flux:table.column class="text-center">Candidats</flux:table.column>
                        <flux:table.column class="text-center">Meilleur score</flux:table.column>
                        <flux:table.column>Statut</flux:table.column>
                        <flux:table.column></flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        <flux:table.row>
                            <flux:table.cell class="font-medium text-zinc-900 dark:text-white">Développeur Laravel Senior</flux:table.cell>
                            <flux:table.cell class="hidden sm:table-cell text-zinc-500">02 juin 2026</flux:table.cell>
                            <flux:table.cell class="text-center font-bold">12</flux:table.cell>
                            <flux:table.cell class="text-center">
                                <flux:badge color="emerald" size="sm" inset="top bottom">94%</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:badge color="emerald" variant="pill" size="sm">Active</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="text-right">
                                <flux:button variant="ghost" size="sm" icon="chevron-right" :href="route('recruiter.offers.applications', ['offer' => 'id-1'])" wire:navigate />
                            </flux:table.cell>
                        </flux:table.row>

                        <flux:table.row>
                            <flux:table.cell class="font-medium text-zinc-900 dark:text-white">Comptable Senior</flux:table.cell>
                            <flux:table.cell class="hidden sm:table-cell text-zinc-500">28 mai 2026</flux:table.cell>
                            <flux:table.cell class="text-center font-bold">5</flux:table.cell>
                            <flux:table.cell class="text-center">
                                <flux:badge color="emerald" size="sm" inset="top bottom">87%</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:badge color="emerald" variant="pill" size="sm">Active</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="text-right">
                                <flux:button variant="ghost" size="sm" icon="chevron-right" :href="route('recruiter.offers.applications', ['offer' => 'id-2'])" wire:navigate />
                            </flux:table.cell>
                        </flux:table.row>

                        <flux:table.row>
                            <flux:table.cell class="font-medium text-zinc-900 dark:text-white">Responsable RH</flux:table.cell>
                            <flux:table.cell class="hidden sm:table-cell text-zinc-500">15 mai 2026</flux:table.cell>
                            <flux:table.cell class="text-center font-bold">2</flux:table.cell>
                            <flux:table.cell class="text-center">
                                <flux:badge color="amber" size="sm" inset="top bottom">71%</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:badge color="emerald" variant="pill" size="sm">Active</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="text-right">
                                <flux:button variant="ghost" size="sm" icon="chevron-right" :href="route('recruiter.offers.applications', ['offer' => 'id-3'])" wire:navigate />
                            </flux:table.cell>
                        </flux:table.row>
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>

        {{-- Zone 3: Alertes --}}
        <div class="space-y-4">
            <flux:heading size="lg">Alertes</flux:heading>

            <div class="space-y-3">
                <div class="p-4 rounded-xl border border-blue-200 bg-blue-50 dark:border-blue-900/30 dark:bg-blue-900/20 flex gap-3">
                    <flux:icon.bell class="size-5 text-blue-600 dark:text-blue-400 shrink-0" />
                    <flux:text size="sm" class="text-blue-800 dark:text-blue-300">
                        <strong>4 nouveaux profils</strong> correspondent à votre offre "Développeur Laravel Senior"
                    </flux:text>
                </div>

                <div class="p-4 rounded-xl border border-amber-200 bg-amber-50 dark:border-amber-900/30 dark:bg-amber-900/20 flex gap-3">
                    <flux:icon.exclamation-triangle class="size-5 text-amber-600 dark:text-amber-400 shrink-0" />
                    <flux:text size="sm" class="text-amber-800 dark:text-amber-300">
                        Votre offre "Responsable RH" <strong>expire dans 5 jours</strong>
                    </flux:text>
                </div>
            </div>
        </div>
    </div>
</div>
