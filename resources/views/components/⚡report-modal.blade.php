<?php

use Livewire\Component;
use App\Enums\ReportReasonEnum;

new class extends Component {
    public $reportableType = 'App\Models\JobOffer';
    public $reportableId;
    public $reason = '';
    public $comment = '';

    public function submit()
    {
        // UI Scaffolding - Simulate success
        $this->dispatch('report-submitted');
    }

    public function getReasons()
    {
        // Filter reasons based on reportableType
        if ($this->reportableType === 'App\Models\JobOffer') {
            return [
                'fake_offer' => 'Offre fictive ou frauduleuse',
                'misleading' => 'Informations trompeuses',
                'discriminatory' => 'Offre discriminatoire',
                'suspicious_contact' => 'Coordonnées suspectes',
                'duplicate' => 'Doublon',
            ];
        } else {
            return [
                'false_info' => 'Informations manifestement fausses',
                'inappropriate' => 'Comportement inapproprié',
                'identity_theft' => 'Usurpation d’identité',
                'spam' => 'Spam',
            ];
        }
    }
}; ?>

<div>
    <flux:modal name="report-modal" class="min-w-[400px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Signaler {{ $reportableType === 'App\Models\JobOffer' ? 'cette offre' : 'ce profil' }}</flux:heading>
                <flux:subheading>Aidez-nous à maintenir la qualité de la plateforme.</flux:subheading>
            </div>

            <form wire:submit="submit" class="space-y-4">
                <flux:field>
                    <flux:label>Raison du signalement</flux:label>
                    <flux:select wire:model="reason" placeholder="Choisir une raison">
                        @foreach ($this->getReasons() as $value => $label)
                            <flux:select.option value="{{ $value }}">{{ $label }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:label>Commentaire (Optionnel)</flux:label>
                    <flux:textarea wire:model="comment" placeholder="Précisez votre signalement..." />
                </flux:field>

                <div class="flex gap-3 justify-end">
                    <flux:modal.close>
                        <flux:button variant="ghost">Annuler</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Envoyer le signalement</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
