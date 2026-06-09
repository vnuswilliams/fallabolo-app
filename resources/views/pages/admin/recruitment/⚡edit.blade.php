<?php

use Livewire\Component;

new #[Title('Tableau de Bord Candidat')] class extends Component {

}; ?>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ route('admin.recruitment.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux offres
        </a>
        <h1 class="text-3xl font-serif font-semibold text-gray-900">Éditer l'offre</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Titre du poste</label>
                <input type="text" placeholder="Ex: Développeur Laravel Senior" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea rows="5" placeholder="Décrivez le rôle..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                        <option value="draft">Brouillon</option>
                        <option value="published">Publiée</option>
                        <option value="closed">Fermée</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Localisation</label>
                    <input type="text" placeholder="Ex: Douala, Cameroon" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                </div>
            </div>

            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.recruitment.index') }}" class="flex-1 px-4 py-3 text-center rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-brand-500 text-white font-medium hover:bg-brand-600 transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

