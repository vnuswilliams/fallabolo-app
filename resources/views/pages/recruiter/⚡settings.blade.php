<?php

use Livewire\Component;

new #[Title('Tableau de Bord Candidat')] class extends Component {

}; ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-serif font-semibold text-gray-900">Paramètres</h1>
        <p class="text-gray-600 mt-2">Gérez vos préférences et paramètres de compte</p>
    </div>

    <div class="space-y-6">
        <!-- Notifications -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Notifications par email</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900">Nouvelles candidatures</p>
                        <p class="text-sm text-gray-600">Recevez une notification pour chaque nouvelle candidature</p>
                    </div>
                    <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-brand-500 cursor-pointer" checked>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900">Digest quotidien</p>
                        <p class="text-sm text-gray-600">Résumé quotidien des candidatures qualifiées</p>
                    </div>
                    <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-brand-500 cursor-pointer" checked>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900">Mises à jour produit</p>
                        <p class="text-sm text-gray-600">Nouvelles fonctionnalités et améliorations</p>
                    </div>
                    <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-brand-500 cursor-pointer">
                </div>
            </div>
        </div>

        <!-- Confidentialité -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Confidentialité</h2>
            <div class="space-y-3">
                <p class="text-sm text-gray-600">Télécharger vos données personnelles</p>
                <button type="button" class="px-4 py-2 rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition">
                    Télécharger mes données
                </button>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-red-50 rounded-2xl border border-red-200 shadow-sm p-6">
            <h2 class="text-lg font-semibold text-red-900 mb-4">Zone de danger</h2>
            <div class="space-y-3">
                <p class="text-sm text-red-800">Supprimer définitivement votre compte et toutes les données associées</p>
                <button type="button" class="px-4 py-2 rounded-xl border border-red-300 text-red-700 font-medium hover:bg-red-100 transition">
                    Supprimer mon compte
                </button>
            </div>
        </div>
    </div>
</div>
