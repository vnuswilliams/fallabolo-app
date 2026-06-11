<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use Spatie\Honeypot\Http\Livewire\Concerns\UsesSpamProtection;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use App\Mail\ContactNotificationMail;
use Illuminate\Support\Facades\Mail;
use Flux\Flux;

new class extends Component {
    use UsesSpamProtection;
    public HoneypotData $extraFields;

    public function mount()
    {
        $this->extraFields = new HoneypotData();
    }

    #[Validate('required|string|min:3')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string|min:5')]
    public string $subject = '';

    #[Validate('required|string|min:10')]
    public string $message = '';

    public function send()
    {
        $this->protectAgainstSpam(); // if is spam, will abort the request
        $this->validate();

        // Envoi du mail à payongvenus@icloud.com
        Mail::to('payongvenus@icloud.com')->queue(new ContactNotificationMail([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
        ]));

        $this->reset();

        Flux::toast(
            variant: 'success',
            heading: 'Message envoyé',
            text: 'Merci de nous avoir contacté. Nous vous répondrons dès que possible.',
        );
    }
}; ?>

<div class="rounded-3xl border p-8 md:p-12 transition-colors duration-300"
     :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
    <form wire:submit="send" class="space-y-6">
            <x-honeypot livewire-model="extraFields" />


        <div class="grid md:grid-cols-2 gap-6">
            <flux:field>
                <flux:label>Nom complet</flux:label>
                <flux:input wire:model="name" placeholder="Votre nom" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>Email</flux:label>
                <flux:input wire:model="email" type="email" placeholder="votre@email.com" />
                <flux:error name="email" />
            </flux:field>
        </div>

        <flux:field>
            <flux:label>Objet</flux:label>
            <flux:input wire:model="subject" placeholder="Sujet de votre message" />
            <flux:error name="subject" />
        </flux:field>

        <flux:field>
            <flux:label>Message</flux:label>
            <flux:textarea wire:model="message" placeholder="Comment pouvons-nous vous aider ?" rows="5" />
            <flux:error name="message" />
        </flux:field>

        <div class="flex justify-center">
            <flux:button type="submit" variant="primary" color="emerald" class="px-10 py-3.5 rounded-xl font-display font-bold bg-emerald-400 text-zinc-900 hover:bg-emerald-500 transition-all hover:-translate-y-0.5 hover:shadow-xl hover:shadow-emerald-500/20">
                Envoyer le message
            </flux:button>
        </div>
    </form>
</div>
