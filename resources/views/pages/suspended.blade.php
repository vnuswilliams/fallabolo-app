<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new #[Title('Compte Suspendu')] #[Layout('layouts.guest')] class extends Component {
    //
}; ?>

<div class="min-h-screen bg-zinc-950 flex items-center justify-center p-6">
    <flux:card class="max-w-md w-full p-8 bg-zinc-900 border-zinc-800 text-center space-y-6">
        <div class="flex justify-center">
            <div class="p-4 bg-rose-500/10 rounded-full">
                <flux:icon.no-symbol class="size-12 text-rose-500" />
            </div>
        </div>

        <div class="space-y-2">
            <flux:heading size="xl" class="text-white">Votre compte est actuellement sous examen</flux:heading>
            <flux:text class="text-zinc-400">
                Nous avons reçu des signalements concernant votre compte ou vos publications.
            </flux:text>
        </div>

        <div class="p-4 bg-zinc-800/50 rounded-xl text-sm text-zinc-300 text-left leading-relaxed">
            Notre équipe examine la situation. Vous serez notifié par email dès qu'une décision sera prise.
        </div>

        <div class="pt-4 border-t border-zinc-800">
            <flux:text size="sm">
                Pour toute question : <a href="mailto:support@matchrh.cm" class="text-emerald-500 hover:underline">support@matchrh.cm</a>
            </flux:text>
        </div>

        <flux:button href="{{ route('logout') }}" variant="ghost" class="w-full text-zinc-500 hover:text-white">
            Se déconnecter
        </flux:button>
    </flux:card>
</div>
