<?php

use Livewire\Component;

new #[Title('Tableau de Bord Candidat')] class extends Component {

}; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ route('candidate.offers.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux offres
        </a>
    </div>

    <!-- Détail de l'offre -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-8">
        <div class="mb-8">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-serif font-semibold text-gray-900">Titre de l'offre</h1>
                    <p class="text-gray-600 mt-2">Entreprise · Douala, Cameroon</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center gap-1 rounded-full border border-brand-200 bg-brand-50 text-brand-600 px-4 py-2 font-semibold">
                        <span>75</span>
                        <span class="text-sm">%</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Compatibilité</p>
                </div>
            </div>

            <!-- Barre de score -->
            <div class="w-full bg-gray-100 rounded-full h-2 mb-4">
                <div class="bg-amber-500 h-2 rounded-full" style="width: 75%"></div>
            </div>

            <!-- Meta -->
            <div class="flex flex-wrap gap-2">
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm font-medium">
                    Cadre
                </span>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm font-medium">
                    200k - 500k FCFA
                </span>
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-sm font-medium">
                    Francophone
                </span>
            </div>
        </div>

        <!-- Description -->
        <div class="border-t border-gray-200 pt-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-3">À propos de ce poste</h2>
            <p class="text-gray-700 leading-relaxed">
                Description détaillée de l'offre d'emploi. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            </p>
        </div>

        <!-- Détail du score -->
        <div class="border-t border-gray-200 pt-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Détail de votre compatibilité</h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-700">Compétences</span>
                    </div>
                    <div class="text-right">
                        <span class="font-semibold text-gray-900">80%</span>
                        <div class="w-24 bg-gray-200 rounded h-1 mt-1">
                            <div class="bg-emerald-500 h-1 rounded" style="width: 80%"></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                    <span class="text-sm font-medium text-gray-700">Expérience</span>
                    <div class="text-right">
                        <span class="font-semibold text-gray-900">70%</span>
                        <div class="w-24 bg-gray-200 rounded h-1 mt-1">
                            <div class="bg-amber-500 h-1 rounded" style="width: 70%"></div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                    <span class="text-sm font-medium text-gray-700">Localisation</span>
                    <div class="text-right">
                        <span class="font-semibold text-gray-900">100%</span>
                        <div class="w-24 bg-gray-200 rounded h-1 mt-1">
                            <div class="bg-emerald-500 h-1 rounded" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="border-t border-gray-200 pt-6 mt-6 flex gap-3">
            <button class="flex-1 px-4 py-3 rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition">
                Enregistrer
            </button>
            <button class="flex-1 px-4 py-3 rounded-xl bg-brand-500 text-white font-medium hover:bg-brand-600 transition">
                Je suis intéressé(e)
            </button>
        </div>
    </div>
</div>
