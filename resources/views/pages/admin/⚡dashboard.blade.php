<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dashboard Admin')] class extends Component {
    // Hardcoded data for UI scaffolding
}; ?>

<div class="flex flex-col gap-8">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl" level="1">Console d'administration</flux:heading>
            <flux:subheading>Vue d'ensemble de la plateforme MatchRH.</flux:subheading>
        </div>
        <div class="flex gap-2">
            <flux:button variant="outline" icon="shield-check">Logs système</flux:button>
            <flux:button variant="primary" icon="user-plus">Créer un admin</flux:button>
        </div>
    </div>

    {{-- Zone 1: Statistiques globales --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <flux:card class="flex flex-col gap-2 p-4 border-zinc-200 dark:border-zinc-800">
            <flux:text size="sm" class="font-medium uppercase tracking-wider">Total Utilisateurs</flux:text>
            <div class="flex items-end justify-between">
                <flux:heading size="xl" class="leading-none">1,248</flux:heading>
                <div class="p-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg">
                    <flux:icon.users class="size-5 text-zinc-600 dark:text-zinc-400" />
                </div>
            </div>
            <div class="flex gap-4 mt-2">
                <flux:text size="xs"><span class="text-emerald-500 font-bold">842</span> Candidats</flux:text>
                <flux:text size="xs"><span class="text-blue-500 font-bold">406</span> Recruteurs</flux:text>
            </div>
        </flux:card>

        <flux:card class="flex flex-col gap-2 p-4 border-zinc-200 dark:border-zinc-800">
            <flux:text size="sm" class="font-medium uppercase tracking-wider">Offres Publiées</flux:text>
            <div class="flex items-end justify-between">
                <flux:heading size="xl" class="leading-none">156</flux:heading>
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                    <flux:icon.briefcase class="size-5 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
            <flux:text size="xs" class="mt-2 text-zinc-500">+12 cette semaine</flux:text>
        </flux:card>

        <flux:card class="flex flex-col gap-2 p-4 border-zinc-200 dark:border-zinc-800 ring-2 ring-amber-500/20">
            <flux:text size="sm" class="font-medium uppercase tracking-wider text-amber-600 dark:text-amber-400">Signalements à traiter</flux:text>
            <div class="flex items-end justify-between">
                <flux:heading size="xl" class="leading-none text-amber-600 dark:text-amber-400">14</flux:heading>
                <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                    <flux:icon.exclamation-triangle class="size-5 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
            <flux:text size="xs" class="mt-2 text-amber-600 dark:text-amber-400 font-bold">Action requise</flux:text>
        </flux:card>

        <flux:card class="flex flex-col gap-2 p-4 border-zinc-200 dark:border-zinc-800">
            <flux:text size="sm" class="font-medium uppercase tracking-wider text-rose-600 dark:text-rose-400">Comptes suspendus</flux:text>
            <div class="flex items-end justify-between">
                <flux:heading size="xl" class="leading-none text-rose-600 dark:text-rose-400">5</flux:heading>
                <div class="p-2 bg-rose-100 dark:bg-rose-900/30 rounded-lg">
                    <flux:icon.no-symbol class="size-5 text-rose-600 dark:text-rose-400" />
                </div>
            </div>
            <flux:text size="xs" class="mt-2 text-zinc-500">Dernière suspension: Hier</flux:text>
        </flux:card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Liste des signalements récents --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <flux:heading size="lg">Signalements récents</flux:heading>
                <flux:button variant="ghost" size="sm">Tout voir</flux:button>
            </div>

            <flux:card class="p-0 overflow-hidden border-zinc-200 dark:border-zinc-800">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Élément</flux:table.column>
                        <flux:table.column>Signalé par</flux:table.column>
                        <flux:table.column>Raison</flux:table.column>
                        <flux:table.column>Date</flux:table.column>
                        <flux:table.column></flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        <flux:table.row>
                            <flux:table.cell>
                                <div class="flex flex-col">
                                    <flux:text size="sm" class="font-medium text-zinc-900 dark:text-white">Offre: Comptable Senior</flux:text>
                                    <flux:text size="xs">FinGroup Yaoundé</flux:text>
                                </div>
                            </flux:table.cell>
                            <flux:table.cell>Jean Ekotto</flux:table.cell>
                            <flux:table.cell>
                                <flux:badge color="amber" size="sm">Fake offer</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="text-zinc-500">Aujourd'hui, 10:45</flux:table.cell>
                            <flux:table.cell>
                                <flux:button variant="ghost" size="sm" icon="eye" />
                            </flux:table.cell>
                        </flux:table.row>

                        <flux:table.row>
                            <flux:table.cell>
                                <div class="flex flex-col">
                                    <flux:text size="sm" class="font-medium text-zinc-900 dark:text-white">Profil: Alain Nkodo</flux:text>
                                    <flux:text size="xs">Candidat</flux:text>
                                </div>
                            </flux:table.cell>
                            <flux:table.cell>TechCorp Douala</flux:table.cell>
                            <flux:table.cell>
                                <flux:badge color="amber" size="sm">False info</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="text-zinc-500">Hier, 16:20</flux:table.cell>
                            <flux:table.cell>
                                <flux:button variant="ghost" size="sm" icon="eye" />
                            </flux:table.cell>
                        </flux:table.row>

                        <flux:table.row>
                            <flux:table.cell>
                                <div class="flex flex-col">
                                    <flux:text size="sm" class="font-medium text-zinc-900 dark:text-white">Offre: Agent de sécurité</flux:text>
                                    <flux:text size="xs">Alpha Security</flux:text>
                                </div>
                            </flux:table.cell>
                            <flux:table.cell>Marie Mballa</flux:table.cell>
                            <flux:table.cell>
                                <flux:badge color="amber" size="sm">Misleading</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="text-zinc-500">05 Juin, 09:15</flux:table.cell>
                            <flux:table.cell>
                                <flux:button variant="ghost" size="sm" icon="eye" />
                            </flux:table.cell>
                        </flux:table.row>
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>

        {{-- Activité récente --}}
        <div class="space-y-4">
            <flux:heading size="lg">Activité récente</flux:heading>
            <div class="space-y-6">
                <div class="flex gap-4">
                    <div class="mt-1 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></div>
                    <div>
                        <flux:text size="sm" class="text-zinc-900 dark:text-white font-medium">Nouvel utilisateur inscrit</flux:text>
                        <flux:text size="xs">Candidat: Paul Atangana à Yaoundé</flux:text>
                        <flux:text size="xs" class="text-zinc-500 mt-1">Il y a 5 min</flux:text>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="mt-1 w-2 h-2 rounded-full bg-blue-500 shrink-0"></div>
                    <div>
                        <flux:text size="sm" class="text-zinc-900 dark:text-white font-medium">Nouvelle offre publiée</flux:text>
                        <flux:text size="xs">Responsable Logistique par SABC</flux:text>
                        <flux:text size="xs" class="text-zinc-500 mt-1">Il y a 25 min</flux:text>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="mt-1 w-2 h-2 rounded-full bg-rose-500 shrink-0"></div>
                    <div>
                        <flux:text size="sm" class="text-zinc-900 dark:text-white font-medium">Compte suspendu</flux:text>
                        <flux:text size="xs">Recruteur: FakeAgency (10+ signalements)</flux:text>
                        <flux:text size="xs" class="text-zinc-500 mt-1">Hier, 18:30</flux:text>
                    </div>
                </div>
            </div>

            <flux:separator class="my-6" />

            <div class="bg-zinc-50 dark:bg-zinc-900/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800">
                <flux:heading size="sm" class="mb-2">Support Technique</flux:heading>
                <flux:text size="xs">Pour toute assistance critique ou accès à la base de données, contactez l'équipe DevOps.</flux:text>
                <flux:button variant="ghost" size="xs" class="mt-4 w-full">Ouvrir un ticket</flux:button>
            </div>
        </div>
    </div>
</div>

