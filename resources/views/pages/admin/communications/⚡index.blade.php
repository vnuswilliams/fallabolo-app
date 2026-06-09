<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use App\Mail\PlatformUpdateMail;
use Illuminate\Support\Facades\Mail;
use Flux\Flux;

new #[Title('Communications Plateforme')] class extends Component {
    public string $subject = '';
    public string $message = '';

    public function sendUpdate()
    {
        $this->validate([
            'subject' => 'required|min:5',
            'message' => 'required|min:20',
        ]);

        $recipients = User::where('updates', true)->get();

        foreach ($recipients as $recipient) {
            Mail::to($recipient->email)->queue(new PlatformUpdateMail($this->subject, $this->message));
        }

        $this->reset(['subject', 'message']);

        Flux::toast(
            variant: 'success',
            heading: 'Emails envoyés',
            text: count($recipients) . ' utilisateurs recevront cette mise à jour.',
        );
    }

    public function getRecipientsCountProperty()
    {
        return User::where('updates', true)->count();
    }
}; ?>

<div class="max-w-4xl mx-auto space-y-8">
    <div>
        <flux:heading size="xl" level="1">Envoyer une mise à jour</flux:heading>
        <flux:subheading>Diffusez un message par email aux utilisateurs inscrits aux updates ({{ $this->recipientsCount }} personnes).</flux:subheading>
    </div>

    <flux:card class="p-8">
        <form wire:submit="sendUpdate" class="space-y-6">
            <flux:field>
                <flux:label>Sujet de l'email</flux:label>
                <flux:input wire:model="subject" placeholder="Ex: Nouvelles fonctionnalités disponibles sur MatchRH !" />
                <flux:error name="subject" />
            </flux:field>

            <flux:field>
                <flux:label>Message (Markdown supporté)</flux:label>
                <flux:textarea wire:model="message" rows="10" placeholder="Décrivez les nouveautés, changements ou annonces..." />
                <flux:error name="message" />
            </flux:field>

            <div class="flex justify-end gap-4">
                <flux:button variant="ghost">Aperçu (Bientôt)</flux:button>
                <flux:button type="submit" variant="primary" icon="paper-airplane">
                    Diffuser aux {{ $this->recipientsCount }} inscrits
                </flux:button>
            </div>
        </form>
    </flux:card>

    <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-xl border border-amber-200 dark:border-amber-800 flex gap-4">
        <flux:icon.information-circle class="size-6 text-amber-600 dark:text-amber-400 shrink-0" />
        <div class="text-sm text-amber-800 dark:text-amber-300">
            <p class="font-bold">Attention</p>
            <p>Ce message sera envoyé uniquement aux utilisateurs ayant coché la case "Recevoir les mises à jour" lors de leur inscription ou dans leurs paramètres.</p>
        </div>
    </div>
</div>
