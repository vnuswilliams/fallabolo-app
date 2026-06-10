<section id="solution" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/40 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-10">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Notre solution
      </div>
      <h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Matching en 4 étapes,<br><span class="grad-text">score transparent</span>
      </h2>
      <p class="text-base max-w-md mx-auto" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Un algorithme déterministe. Pas de boîte noire chaque score est expliqué, visible et contestable.
      </p>
    </div>

    <!-- Steps -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 rounded-2xl overflow-hidden border mb-16"
         :class="dark ? 'border-zinc-800 bg-zinc-800' : 'border-zinc-200 bg-zinc-200'" style="gap:1px">
      <div class="p-6 reveal d1 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">01</div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Critères bloquants</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Éliminatoires. Si un critère obligatoire n'est pas rempli, le score tombe à 0 automatiquement.</p>
      </div>
      <div class="p-6 reveal d2 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">02</div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Score principal pondéré</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">6 dimensions clés (compétences 50 %, expérience 20 %…) combinées en un score sur 100.</p>
      </div>
      <div class="p-6 reveal d3 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">03</div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Points bonus</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Certifications, compétences rares, langues supplémentaires des points qui distinguent les excellents profils.</p>
      </div>
      <div class="p-6 reveal d4 transition-colors" :class="dark ? 'bg-zinc-900 hover:bg-zinc-800' : 'bg-white hover:bg-zinc-50'">
        <div class="font-display font-extrabold text-4xl mb-4 grad-text leading-none">04</div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Score final en %</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Un chiffre clair, visible avant même de postuler. Le candidat sait. Le recruteur a son classement.</p>
      </div>
    </div>

    <!-- Weights + Score preview -->
    <div class="grid md:grid-cols-2 gap-8">

      <!-- Barres de pondération -->
      <div class="reveal-l self-center">
        <p class="text-xs font-bold font-display uppercase tracking-widest mb-5"
           :class="dark ? 'text-emerald-400' : 'text-emerald-700'">Pondérations fixes & transparentes</p>
        <div class="space-y-4">
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Compétences</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="50" style="--w:50%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">50%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Expérience</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="20" style="--w:20%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">20%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Formation</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="10" style="--w:10%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">10%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Langues</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="10" style="--w:10%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">10%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Disponibilité</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="5" style="--w:5%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">5%</div>
          </div>
          <div class="flex items-center gap-3">
            <div class="text-sm w-24 shrink-0" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Localisation</div>
            <div class="flex-1 h-2 rounded-full overflow-hidden" :class="dark ? 'bg-zinc-800' : 'bg-zinc-200'">
              <div class="bar-fill h-full rounded-full bg-linear-to-r from-emerald-600 to-emerald-400" data-w="5" style="--w:5%"></div>
            </div>
            <div class="text-sm font-bold font-display w-9 text-right" :class="dark ? 'text-emerald-400' : 'text-emerald-600'">5%</div>
          </div>
        </div>
      </div>

      <!-- Score preview -->
      <div class="reveal-r rounded-2xl border p-6" :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-zinc-50 border-zinc-200'">
        <div class="flex items-center justify-between mb-5">
          <h4 class="font-display font-bold text-sm" :class="dark ? 'text-zinc-300' : 'text-zinc-600'">Compatibilité estimée</h4>
          <span class="font-display font-extrabold text-4xl grad-text">84%</span>
        </div>
        <div class="space-y-3 mb-5">
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Compétences</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Excellent</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Expérience</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Compatible</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Langues</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Compatible</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Disponibilité</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Immédiate</span>
          </div>
          <div class="flex items-center gap-3 text-sm">
            <span class="text-emerald-400">✓</span>
            <span class="flex-1" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Localisation</span>
            <span class="font-medium" :class="dark ? 'text-zinc-200' : 'text-zinc-700'">Compatible</span>
          </div>
        </div>
        <div class="pt-4 border-t" :class="dark ? 'border-zinc-800' : 'border-zinc-200'">
          <p class="text-xs mb-2" :class="dark ? 'text-zinc-500' : 'text-zinc-400'">Bonus cumulés</p>
          <div class="flex flex-wrap gap-2">
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">+5 Sage Paie</span>
            <span class="px-3 py-1 rounded-lg text-xs font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">+3 Excel avancé</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
