<section id="probleme" class="py-24 px-5 transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-5xl mx-auto">
    <div class="reveal mb-12">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Problème
      </div>
      <h2 class="font-display font-bold leading-tight mb-3" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Le recrutement classique est cassé
      </h2>
      <p class="text-base max-w-md" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Des centaines de candidatures par poste. Des heures perdues à trier des PDFs. MatchRH y met fin.
      </p>
    </div>

    <div class="grid sm:grid-cols-2 rounded-2xl overflow-hidden border"
         :class="dark ? 'border-zinc-800 bg-zinc-800' : 'border-zinc-200 bg-zinc-200'" style="gap:1px">
      <div class="p-7 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800/80' : 'bg-white hover:bg-zinc-50'">
        <div class="w-11 h-11 p-4 rounded-xl flex items-center justify-center text-xl mb-5 border"
             :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
            <flux:icon.envelope class="size-8" />
            </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Candidatures massives et non pertinentes</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Chaque offre attire des dizaines de profils inadaptés, noyant les bons candidats dans la masse.</p>
      </div>
      <div class="p-7 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800/80' : 'bg-white hover:bg-zinc-50'">
        <div class="w-11 h-11 p-4 rounded-xl flex items-center justify-center text-xl mb-5 border"
             :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
            <flux:icon.clock class="size-8" />
            </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Tri manuel chronophage</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Un recruteur passe en moyenne 6 secondes sur un CV. La qualité de la décision est sacrifiée pour la vitesse.</p>
      </div>
      <div class="p-7 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800/80' : 'bg-white hover:bg-zinc-50'">
        <div class="w-11 h-11 p-4 rounded-xl flex items-center justify-center text-xl mb-5 border"
             :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
            <flux:icon.document class="size-8" />
            </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Lettres de motivation jamais lues</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Étape vide de sens, supprimée chez nous. Une perte de temps pour toutes les parties.</p>
      </div>
      <div class="p-7 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800/80' : 'bg-white hover:bg-zinc-50'">
        <div class="w-11 h-11 p-4 rounded-xl flex items-center justify-center text-xl mb-5 border"
             :class="dark ? 'bg-red-500/10 border-red-500/20' : 'bg-red-50 border-red-200'">
            <flux:icon.folder class="size-8" />
            </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Données non comparables</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Des compétences dispersées dans des PDFs impossibles à comparer objectivement entre candidats.</p>
      </div>
    </div>
  </div>
</section>
