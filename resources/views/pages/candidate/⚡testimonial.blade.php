<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Testimonial;
use App\Enums\TestimonialStatusEnum;
use Illuminate\Support\Facades\Auth;
use Flux\Flux;

new #[Title('Mon Avis')] class extends Component {

    public int    $rating  = 5;
    public string $content = '';

    public function mount(): void
    {
        // Pré-charger l'avis existant s'il y en a un
        $existing = Testimonial::where('user_id', Auth::id())->latest()->first();
        if ($existing) {
            $this->rating  = $existing->rating;
            $this->content = $existing->content;
        }
    }

    public function getExistingTestimonialProperty(): ?Testimonial
    {
        return Testimonial::where('user_id', Auth::id())->latest()->first();
    }

    public function submit(): void
    {
        $this->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:20|max:1000',
        ], [
            'content.min' => 'Votre avis doit contenir au moins 20 caractères.',
            'content.max' => 'Votre avis ne peut pas dépasser 1000 caractères.',
        ]);

        $existing = Testimonial::where('user_id', Auth::id())->latest()->first();

        if ($existing) {
            // Remettre en attente si modifié
            $existing->update([
                'content' => $this->content,
                'rating'  => $this->rating,
                'status'  => TestimonialStatusEnum::PENDING,
            ]);

            Flux::toast(
                variant: 'success',
                heading: 'Avis mis à jour',
                text: 'Votre avis a été soumis à nouveau et sera examiné par notre équipe.',
            );
        } else {
            Testimonial::create([
                'user_id' => Auth::id(),
                'content' => $this->content,
                'rating'  => $this->rating,
                'status'  => TestimonialStatusEnum::PENDING,
            ]);

            Flux::toast(
                variant: 'success',
                heading: 'Avis envoyé !',
                text: 'Merci pour votre retour. Il sera visible après validation.',
            );
        }
    }

    public function delete(): void
    {
        $existing = Testimonial::where('user_id', Auth::id())->latest()->first();
        if ($existing) {
            $existing->delete();
            $this->content = '';
            $this->rating  = 5;

            Flux::toast(
                variant: 'success',
                heading: 'Avis supprimé',
                text: 'Votre avis a été retiré de la plateforme.',
            );
        }
    }
}; ?>

<div class="max-w-2xl mx-auto space-y-8">
    <div>
        <flux:heading size="xl" level="1">Mon Avis</flux:heading>
        <flux:subheading>Partagez votre expérience avec MatchRH. Votre avis aide à améliorer la plateforme.</flux:subheading>
    </div>

    {{-- Statut de l'avis existant --}}
    @if ($this->existingTestimonial)
        <div @class([
            'flex items-center gap-3 p-4 rounded-xl border',
            'bg-amber-50 border-amber-200 dark:bg-amber-900/20 dark:border-amber-800' => $this->existingTestimonial->status === \App\Enums\TestimonialStatusEnum::PENDING,
            'bg-emerald-50 border-emerald-200 dark:bg-emerald-900/20 dark:border-emerald-800' => $this->existingTestimonial->status === \App\Enums\TestimonialStatusEnum::APPROVED,
            'bg-rose-50 border-rose-200 dark:bg-rose-900/20 dark:border-rose-800' => $this->existingTestimonial->status === \App\Enums\TestimonialStatusEnum::REJECTED,
        ])>
            @if ($this->existingTestimonial->status === \App\Enums\TestimonialStatusEnum::PENDING)
                <flux:icon.clock class="size-5 text-amber-600 dark:text-amber-400 shrink-0" />
                <flux:text class="text-amber-800 dark:text-amber-300 text-sm">
                    Votre avis est <strong>en attente de validation</strong> par notre équipe.
                </flux:text>
            @elseif ($this->existingTestimonial->status === \App\Enums\TestimonialStatusEnum::APPROVED)
                <flux:icon.check-circle class="size-5 text-emerald-600 dark:text-emerald-400 shrink-0" />
                <flux:text class="text-emerald-800 dark:text-emerald-300 text-sm">
                    Votre avis est <strong>publié</strong> sur la plateforme.
                </flux:text>
            @else
                <flux:icon.x-circle class="size-5 text-rose-600 dark:text-rose-400 shrink-0" />
                <flux:text class="text-rose-800 dark:text-rose-300 text-sm">
                    Votre avis a été <strong>rejeté</strong>. Vous pouvez le modifier et le soumettre à nouveau.
                </flux:text>
            @endif
        </div>
    @endif

    <flux:card class="p-6 space-y-6">

        {{-- Note en étoiles --}}
        <flux:field>
            <flux:label>Votre note</flux:label>
            <div class="flex items-center gap-2 mt-2"
                 x-data="{ rating: @entangle('rating') }">
                @for ($i = 1; $i <= 5; $i++)
                    <button
                        type="button"
                        x-on:click="rating = {{ $i }}"
                        class="transition-transform hover:scale-110 focus:outline-none"
                        aria-label="Note {{ $i }}/5"
                    >
                        <flux:icon.star
                            :class="$i <= $rating ? 'text-amber-400 fill-amber-400' : 'text-zinc-300 dark:text-zinc-600'"
                            class="size-8"
                        />
                    </button>
                @endfor
                <flux:text size="sm" class="ml-3 text-zinc-500">{{ $rating }}/5</flux:text>
            </div>
            <flux:error name="rating" />
        </flux:field>

        {{-- Contenu de l'avis --}}
        <flux:field>
            <flux:label>Votre témoignage</flux:label>
            <flux:textarea
                wire:model="content"
                rows="5"
                placeholder="Décrivez votre expérience avec MatchRH : en tant que candidat ou recruteur, qu'est-ce qui vous a le plus aidé ? (minimum 20 caractères)"
            />
            <div class="flex justify-between items-center mt-1">
                <flux:error name="content" />
                <flux:text size="xs" class="text-zinc-400 ml-auto">{{ strlen($content) }}/1000</flux:text>
            </div>
        </flux:field>

        {{-- Actions --}}
        <div class="flex items-center justify-between gap-4 pt-2">
            @if ($this->existingTestimonial)
                <flux:button
                    wire:click="delete"
                    wire:confirm="Êtes-vous sûr de vouloir supprimer votre avis ?"
                    variant="ghost"
                    icon="trash"
                    class="text-rose-500 hover:text-rose-600"
                >
                    Supprimer mon avis
                </flux:button>
            @else
                <div></div>
            @endif

            <flux:button
                wire:click="submit"
                variant="primary"
                icon="paper-airplane"
            >
                {{ $this->existingTestimonial ? 'Mettre à jour mon avis' : 'Envoyer mon avis' }}
            </flux:button>
        </div>
    </flux:card>

    {{-- Info --}}
    <div class="flex gap-3 p-4 rounded-xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800">
        <flux:icon.information-circle class="size-5 text-zinc-400 shrink-0 mt-0.5" />
        <flux:text size="sm" class="text-zinc-500">
            Les avis sont examinés par notre équipe avant publication. Les témoignages approuvés peuvent être affichés sur la page d'accueil de MatchRH.
        </flux:text>
    </div>
</div>
