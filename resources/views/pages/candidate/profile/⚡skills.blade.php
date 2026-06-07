<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\CandidateProfile;
use Illuminate\Support\Facades\Auth;

new #[Title('Mon Profil')] class extends Component {
    public function candidateProfile()
    {
        return Auth::user()->candidateProfile;
    }
}; ?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ route('candidate.profile.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium flex items-center gap-1 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour au profil
        </a>
        <h1 class="text-3xl font-serif font-semibold text-gray-900">Gérer mes compétences</h1>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
        <div class="mb-6">
            <p class="text-gray-600 mb-4">Sélectionnez vos compétences et évaluez votre niveau pour chacune</p>

            <!-- Ajouter une compétence -->
            <div class="flex gap-3 mb-6">
                <select class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-50">
                    <option value="">Sélectionner une compétence</option>
                    <option value="1">Laravel</option>
                    <option value="2">PHP</option>
                    <option value="3">JavaScript</option>
                    <option value="4">React</option>
                </select>
                <button type="button" class="px-6 py-3 bg-brand-500 text-white rounded-xl font-medium hover:bg-brand-600 transition">
                    Ajouter
                </button>
            </div>
        </div>

        <!-- Liste des compétences -->
        <div class="space-y-3 mb-6">
            <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-900">Laravel</p>
                    <p class="text-sm text-gray-600">Catégorie: Développement</p>
                </div>
                <div class="flex items-center gap-3">
                    <select class="px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-brand-500 text-sm">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4" selected>4</option>
                        <option value="5">5</option>
                    </select>
                    <button type="button" class="text-red-600 hover:text-red-700 text-sm font-medium">
                        Supprimer
                    </button>
                </div>
            </div>

            <div class="p-4 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-900">PHP</p>
                    <p class="text-sm text-gray-600">Catégorie: Développement</p>
                </div>
                <div class="flex items-center gap-3">
                    <select class="px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:border-brand-500 text-sm">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4" selected>4</option>
                        <option value="5">5</option>
                    </select>
                    <button type="button" class="text-red-600 hover:text-red-700 text-sm font-medium">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('candidate.profile.index') }}" class="flex-1 px-4 py-3 text-center rounded-xl border border-gray-200 text-gray-700 font-medium hover:bg-gray-50 transition">
                Retour
            </a>
            <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-brand-500 text-white font-medium hover:bg-brand-600 transition">
                Enregistrer
            </button>
        </div>
    </div>
</div>
