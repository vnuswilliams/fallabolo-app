<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\RecruiterProfile;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;

new #[Title('Profil Entreprise')] class extends Component {
}; ?>


<div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-serif font-semibold text-gray-900 mb-8">Éditer le profil</h1>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
            <!-- Contenu d'édition du profil -->
            <p class="text-gray-600">Formulaire d'édition du profil entreprise</p>
        </div>
    </div>
</div>
