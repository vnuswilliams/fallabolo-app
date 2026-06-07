<?php

use Livewire\Component;

new #[Title('Tableau de Bord Candidat')] class extends Component {

}; ?>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ route('recruiter.offers.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux offres
        </a>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-serif font-semibold text-gray-900">Candidatures reçues</h1>
                <p class="text-gray-600 mt-2">Pour l'offre: Développeur Laravel Senior</p>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <!-- Filtres -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex gap-3 items-center">
            <input type="text" placeholder="Chercher un candidat..." class="flex-1 px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-brand-500">
            <select class="px-4 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-brand-500">
                <option value="">Tous les statuts</option>
                <option value="new">Nouveaux</option>
                <option value="viewed">Consultés</option>
                <option value="shortlisted">Présélectionnés</option>
                <option value="rejected">Rejetés</option>
            </select>
        </div>

        <!-- Liste des candidatures -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <p class="text-gray-500">Aucune candidature pour le moment</p>
            </div>
        </div>
    </div>
    </div>

