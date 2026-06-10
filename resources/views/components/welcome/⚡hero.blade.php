<section class="relative pt-32 pb-24 px-5 text-center overflow-hidden">
  <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-[500px] pointer-events-none"
       style="background:radial-gradient(ellipse,rgba(52,211,153,.13) 0%,transparent 70%)"></div>
  <div class="absolute inset-0 hero-grid pointer-events-none"></div>
  <div class="relative max-w-5xl mx-auto">

    <div class="reveal inline-flex items-center gap-2 px-4 py-1.5 rounded-full border text-sm font-medium mb-6"
         :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
      <span class="px-2 py-0.5 rounded-full text-xs font-bold font-display bg-emerald-400 text-zinc-900">NOUVEAU</span>
      Matching algorithmique transparent sans CV obligatoire
    </div>

    <h1 class="reveal d1 font-display font-extrabold leading-[1.06] tracking-tight mb-5" style="font-size:clamp(2.4rem,7vw,4.8rem)">
      Recrutement sans bruit,<br>
      <span class="grad-text">matching au mérite</span>
    </h1>

    <p class="reveal d2 text-lg font-light max-w-xl mx-auto mb-10 leading-relaxed"
       :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
      Fini le tri manuel de centaines de CVs. MatchRH connecte talents et recruteurs via un scoring structuré, transparent et instantané.
    </p>

    <div class="reveal d3 flex flex-wrap gap-3 justify-center mb-16">
      <flux:button href="{{ route('register') }}" class="px-7 py-3.5 rounded-xl font-display font-bold text-zinc-900 bg-emerald-400 hover:bg-emerald-500 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-emerald-500/25">
        Créer un compte gratuit
      </flux:button>
      <flux:button class="px-7 py-3.5 rounded-xl font-medium border transition-all hover:-translate-y-0.5"
              :class="dark ? 'border-zinc-700 text-zinc-300 hover:border-zinc-500 hover:bg-zinc-800/50' : 'border-zinc-200 text-zinc-600 hover:border-zinc-400 hover:bg-zinc-50'">
        Voir la démo  <flux:icon.chevron-right class="size-4 inline-block ml-1"/>
      </flux:button>
    </div>

    <!-- Stats -->
    <div class="reveal d4 grid grid-cols-2 sm:grid-cols-4 gap-6 pt-10 border-t"
         :class="dark ? 'border-zinc-800' : 'border-zinc-200'">
      <div class="text-center">
        <div class="font-display font-extrabold text-2xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">−87%</div>
        <div class="text-xs mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Temps de tri</div>
      </div>
      <div class="text-center">
        <div class="font-display font-extrabold text-2xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">4 étapes</div>
        <div class="text-xs mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Processus clair</div>
      </div>
      <div class="text-center">
        <div class="font-display font-extrabold text-2xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">100%</div>
        <div class="text-xs mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Transparent</div>
      </div>
      <div class="text-center">
        <div class="font-display font-extrabold text-2xl" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">0 CV</div>
        <div class="text-xs mt-1" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Requis</div>
      </div>
    </div>
  </div>
</section>
