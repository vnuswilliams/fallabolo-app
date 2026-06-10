<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Faq;
use App\Enums\ReportStatusEnum;
use Illuminate\Support\Facades\Mail;
use App\Mail\FaqMail;

new class extends Component {

    #[Validate('required|email|max:20')]
    public string $email = "";

    #[Validate('required|string|max:200')]
    public string $question = "";

    public int $loaded = 10;
    public function sendQuestion()
    {
        $this->validate();
        $faq = Faq::create([
            "email" => $this->email,
            "question" => $this->question
        ]);

        Mail::to($this->email)->queue(new FaqMail());
        Flux::modals()->close();
        if($faq) return Flux::toast(variant:'success', text:"Votre question a été soumise avec succès.");
    }
    public function loadMore()
    {


    }
    public function with():array
    {
        return[

            'faqs' => Faq::where('status', ReportStatusEnum::CONFIRMED)
            ->limit($this->loaded)
            ->latest()
            ->get(),

            ];
                }

}; ?>

<section id="faq" class="border-y transition-colors duration-300"
         :class="dark ? 'border-zinc-800 bg-zinc-950' : 'border-zinc-200 bg-slate-50'">
    <div class="mx-auto max-w-3xl px-5 py-14 sm:py-20 lg:px-8">


        {{-- En-tête --}}
        <div class="mb-10 text-center">
            <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
                 :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
                Foire aux questions
            </div>
            <h2 class="font-display font-bold leading-tight mb-3" style="font-size:clamp(1.6rem,4vw,2.4rem)"
                :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
                Tout ce que vous voulez savoir<br class="hidden sm:block"> avant de vous lancer.
            </h2>
            <p class="text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
                Candidats et recruteurs vos questions les plus fréquentes.
            </p>
        </div>

        {{-- Accordéon --}}
        <div class="space-y-3">
            @foreach ($faqs as $index => $faq)
                <details
                    class="group rounded-2xl border transition-colors duration-200"
                    :class="dark
                        ? 'bg-zinc-900 border-zinc-800 open:border-emerald-500/30'
                        : 'bg-white border-zinc-200 open:border-emerald-300'"
                    @if ($index === 0) open @endif
                >
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 sm:py-5">
                        <span class="font-semibold text-sm leading-snug sm:text-base"
                              :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
                            {{ $faq['question'] }}
                        </span>
                        <span class="grid size-7 shrink-0 place-items-center rounded-lg border transition-all duration-200
                                     group-open:rotate-45"
                              :class="dark
                                  ? 'border-zinc-700 bg-zinc-800 text-zinc-300 group-open:border-emerald-500/30 group-open:bg-emerald-500/10 group-open:text-emerald-400'
                                  : 'border-zinc-200 bg-zinc-100 text-zinc-500 group-open:border-emerald-300 group-open:bg-emerald-50 group-open:text-emerald-600'">
                            <flux:icon.plus class="size-3.5" />
                        </span>
                    </summary>

                    <div class="border-t px-5 pb-5 pt-4 text-sm leading-relaxed"
                         :class="dark ? 'border-zinc-800 text-zinc-400' : 'border-zinc-100 text-zinc-500'">
                        {{ $faq['answer'] }}
                    </div>
                </details>
            @endforeach

            <div  class="mx-auto flex items-center justify-center" >

                <flux:link wire:click="loadMore">
                    Voir plus
                </flux:link>
            </div>

        </div>

        {{-- CTA bas --}}
        <div class="mt-8 rounded-2xl border p-6 text-center"
             :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-white border-zinc-200'">
            <p class="font-semibold text-sm mb-4"
               :class="dark ? 'text-zinc-200' : 'text-zinc-700'">
                Vous avez une question spécifique à votre situation ?
            </p>
            <flux:modal.trigger name="report-modal">
                <flux:button variant="primary" color="emerald"
                class="inline-flex items-center gap-2 px-7 py-3 rounded-xl font-display font-bold text-sm
                        bg-emerald-400 text-zinc-900 hover:bg-emerald-500 transition-all
                        hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/20">
                    Posez la nous directement
                </flux:button>
            </flux:modal.trigger >
        </div>
    </div>


    <flux:modal name="report-modal" class="min-w-[500px]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Votre question </flux:heading>
                <flux:text>Posez votre question et nous vous y répondrons dans les plus bref délai.</flux:text>
            </div>

            <form wire:submit="sendQuestion" class="space-y-4">

                <flux:field>
                    <flux:input label="Quel est votre email ?" wire:model="email" type="email" />
                </flux:field>


                <flux:field>
                    <flux:label>Quel est votre question ?</flux:label>
                    <flux:textarea wire:model="question" placeholder="n'hesitez pas à être le plus explicite possible (max 200 mots) " />
                </flux:field>

                <div class="flex gap-3 justify-end">
                    <flux:modal.close>
                        <flux:button variant="ghost">Annuler</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Soumettez votre question</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</section>
