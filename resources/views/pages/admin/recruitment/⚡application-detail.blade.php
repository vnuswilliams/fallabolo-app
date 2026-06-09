<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Détail Candidat')] class extends Component {
    // Hardcoded data for UI scaffolding
}; ?>

<div class="max-w-3xl mx-auto space-y-8 pb-12">
    <flux:link :href="route('admin.recruitment.applications', ['offer' => 'id-1'])" icon="chevron-left" variant="ghost">Retour à la liste</flux:link>

    <flux:card class="p-0 overflow-hidden border-zinc-200 dark:border-zinc-800">
        {{-- Header Profil --}}
        <div class="p-8 bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-200 dark:border-zinc-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-2xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-3xl font-bold text-zinc-400">
                        JE
                    </div>
                    <div>
                        <flux:heading size="xl">Jean Ekotto</flux:heading>
                        <flux:text  class="flex items-center gap-2 mt-1">
                            <flux:icon.map-pin class="size-4" /> Douala, Cameroun
                        </flux:text>
                        <div class="flex gap-2 mt-4">
                            <flux:badge color="emerald" variant="pill">Candidat Vérifié</flux:badge>
                            <flux:badge variant="pill">Disponible : Immédiat</flux:badge>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-center p-4 bg-white dark:bg-zinc-800 rounded-2xl border border-zinc-200 dark:border-zinc-700">
                    <flux:text size="xs" class="uppercase tracking-widest font-bold text-zinc-500">Compatibilité</flux:text>
                    <flux:heading size="xl" class="text-emerald-500">94%</flux:heading>
                </div>
            </div>
        </div>

        {{-- Détails du Score --}}
        <div class="p-8 space-y-8">
            <div>
                <flux:heading size="lg" class="mb-6">Décomposition du score</flux:heading>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-zinc-100 dark:border-zinc-800">
                        <flux:text>Compétences</flux:text>
                        <div class="flex items-center gap-3">
                            <flux:text class="font-bold">88%</flux:text>
                            <flux:icon.check-circle variant="solid" class="text-emerald-500 size-5" />
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
                <flux:heading size="lg" class="mb-4">Atouts recherchés (3/5 détectés)</flux:heading>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <flux:icon.check class="text-emerald-500 size-4" />
                        <flux:text>Expérience Télécoms <span class="text-xs text-zinc-500 font-bold ml-2 uppercase">(Fort)</span></flux:text>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:icon.x-mark class="text-zinc-300 size-4" />
                        <flux:text class="text-zinc-400 line-through">Certification AWS</flux:text>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:icon.check class="text-emerald-500 size-4" />
                        <flux:text>Expérience télétravail <span class="text-xs text-zinc-500 font-bold ml-2 uppercase">(Moyen)</span></flux:text>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:icon.check class="text-emerald-500 size-4" />
                        <flux:text>Anglais professionnel <span class="text-xs text-zinc-500 font-bold ml-2 uppercase">(Faible)</span></flux:text>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:icon.x-mark class="text-zinc-300 size-4" />
                        <flux:text class="text-zinc-400 line-through">Expérience en PME</flux:text>
                    </div>
                </div>
            </div>

            <flux:separator />

            {{-- Compétences supplémentaires --}}
            <div>
                <flux:heading size="lg" class="mb-4">Compétences supplémentaires (2)</flux:heading>
                <div class="flex flex-wrap gap-2">
                    <flux:badge variant="outline" icon="cpu-chip">Vue.js</flux:badge>
                    <flux:badge variant="outline" icon="cpu-chip">Docker</flux:badge>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="p-8 bg-zinc-50 dark:bg-zinc-900/50 flex flex-wrap gap-4 border-t border-zinc-200 dark:border-zinc-800">
            <flux:button variant="primary" icon="check" class="flex-1">Shortlister</flux:button>
            <flux:button variant="danger" icon="x-mark" class="flex-1">Rejeter</flux:button>
            <flux:modal.trigger name="report-modal">
                <flux:button variant="ghost" icon="exclamation-triangle" class="text-amber-600">Signaler</flux:button>
            </flux:modal.trigger>
        </div>
    </flux:card>

    <livewire:report-modal type="candidate" />
</div>
