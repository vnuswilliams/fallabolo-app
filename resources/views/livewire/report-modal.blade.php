<?php

use Livewire\Volt\Component;

new class extends Component {
    public $type; // 'offer' or 'candidate'
    public $reasons = [];
    public $reason = '';
    public $comment = '';

    public function mount($type)
    {
        $this->type = $type;
        $this->reasons = $type === 'offer' ? [
            'fake_offer' => 'Offre fictive ou frauduleuse',
            'misleading' => 'Informations trompeuses',
            'discriminatory' => 'Offre discriminatoire',
            'suspicious_contact' => 'Coordonnées suspectes',
            'duplicate' => 'Doublon',
        ] : [
            'false_info' => 'Informations manifestement fausses',
            'inappropriate' => 'Comportement inapproprié',
            'identity_theft' => 'Usurpation d’identité',
            'spam' => 'Spam',
        ];
    }

    public function submit()
    {
        // UI Scaffolding - Simulate success
        $this->dispatch('report-submitted');
        $this->dispatch('modal-close', id: 'report-modal');
    }
}; ?>

<div>
    <flux:modal id="report-modal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Signaler {{ $type === 'offer' ? 'cette offre' : 'ce profil' }}</flux:heading>
                <flux:subheading>Merci de nous aider à maintenir la qualité de MatchRH.</flux:subheading>
            </div>

            <flux:field>
                <flux:label>Raison du signalement</flux:label>
                <flux:select wire:model="reason" placeholder="Choisissez une raison">
                    @foreach ($reasons as $value => $label)
                        <flux:select.option value="{{ $value }}">{{ $label }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:field>
                <flux:label>Commentaire (optionnel)</flux:label>
                <flux:textarea wire:model="comment" rows="3" placeholder="Précisez la situation..." />
            </flux:field>

            <div class="flex gap-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Annuler</flux:button>
                </flux:modal.close>
                <flux:button wire:click="submit" variant="primary">Envoyer le signalement</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
