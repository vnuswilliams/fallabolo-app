<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Détail de l\'offre')] class extends Component {
    // Hardcoded data for UI scaffolding
}; ?>

<div class="max-w-3xl mx-auto space-y-8 pb-12">
    <flux:link :href="route('candidate.offers.index')" icon="chevron-left" variant="ghost">Retour aux offres</flux:link>

    <flux:card class="p-0 overflow-hidden border-zinc-200 dark:border-zinc-800">
        {{-- Header Offre --}}
        <div class="p-8 bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-200 dark:border-zinc-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center">
                        <flux:icon.building-office class="size-8 text-zinc-400" />
                    </div>
                    <div>
                        <flux:heading size="xl">Développeur Laravel Senior</flux:heading>
                        <flux:text  class="flex items-center gap-2 mt-1">
                            TechCorp · Douala · Publiée le 02 juin 2026
                        </flux:text>
                    </div>
                </div>

                <div class="flex flex-col items-center p-4 bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700">
                    <flux:text size="xs" class="uppercase tracking-widest font-bold text-zinc-500">Votre Compatibilité</flux:text>
                    <flux:heading size="xl" class="text-emerald-500">87%</flux:heading>
                </div>
            </div>
        </div>

        {{-- Détails du Score pour le Candidat --}}
        <div class="p-8 space-y-8">
            <div>
                <flux:heading size="lg" class="mb-6">Pourquoi ce score ?</flux:heading>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
                        <flux:text>Compétences</flux:text>
                        <div class="flex items-center gap-3">
                            <flux:text class="font-bold">68%</flux:text>
                            <flux:icon.exclamation-circle variant="solid" class="text-amber-500 size-5" />
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
                        <flux:text>Expérience</flux:text>
                        <div class="flex items-center gap-3">
                            <flux:text class="font-bold">100%</flux:text>
                            <flux:icon.check-circle variant="solid" class="text-emerald-500 size-5" />
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
                        <flux:text>Formation</flux:text>
                        <div class="flex items-center gap-3">
                            <flux:text class="font-bold">45%</flux:text>
                            <flux:icon.exclamation-circle variant="solid" class="text-amber-500 size-5" />
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
                        <flux:text>Disponibilité</flux:text>
                        <div class="flex items-center gap-3">
                            <flux:text class="font-bold">100%</flux:text>
                            <flux:icon.check-circle variant="solid" class="text-emerald-500 size-5" />
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
                        <flux:text>Localisation</flux:text>
                        <div class="flex items-center gap-3">
                            <flux:text class="font-bold">100%</flux:text>
                            <flux:icon.check-circle variant="solid" class="text-emerald-500 size-5" />
                        </div>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
                        <flux:text>Salaire</flux:text>
                        <div class="flex items-center gap-3">
                            <flux:text class="font-bold">100%</flux:text>
                            <flux:icon.check-circle variant="solid" class="text-emerald-500 size-5" />
                        </div>
                    </div>
                </div>
            </div>

            <flux:separator />

            {{-- Atouts --}}
            <div>
                <flux:heading size="lg" class="mb-4">Atouts détectés sur votre profil (3/5)</flux:heading>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center gap-3">
                        <flux:icon.check class="text-emerald-500 size-4" />
                        <flux:text size="sm">Expérience secteur Télécoms</flux:text>
                    </div>
                    <div class="flex items-center gap-3 opacity-50">
                        <flux:icon.x-mark class="text-zinc-400 size-4" />
                        <flux:text size="sm">Certification AWS</flux:text>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:icon.check class="text-emerald-500 size-4" />
                        <flux:text size="sm">Expérience télétravail</flux:text>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:icon.check class="text-emerald-500 size-4" />
                        <flux:text size="sm">Anglais professionnel</flux:text>
                    </div>
                    <div class="flex items-center gap-3 opacity-50">
                        <flux:icon.x-mark class="text-zinc-400 size-4" />
                        <flux:text size="sm">Expérience en PME</flux:text>
                    </div>
                </div>
            </div>

            <flux:separator />

            {{-- Description --}}
            <div class="space-y-4">
                <flux:heading size="lg">Description du poste</flux:heading>
                <flux:text class="leading-relaxed">
                    TechCorp recherche un développeur Laravel senior pour rejoindre notre équipe à Douala.
                    Vous serez responsable de la conception et du développement de solutions web robustes...
                    <br><br>
                    <strong>Missions :</strong>
                    <ul class="list-disc pl-5 mt-2 space-y-2">
                        <li>Développement de nouvelles fonctionnalités sous Laravel 13</li>
                        <li>Optimisation des performances et de la sécurité</li>
                        <li>Mentorat des développeurs juniors</li>
                    </ul>
                </flux:text>
            </div>
        </div>

        {{-- Actions --}}
        <div class="p-8 bg-zinc-50 dark:bg-zinc-900/50 flex flex-wrap gap-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button variant="primary" class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-zinc-950 font-bold">Je suis intéressé</flux:button>
            <flux:button variant="ghost" icon="exclamation-triangle" class="text-amber-600">Signaler l'offre</flux:button>
        </div>
    </flux:card>
</div>
