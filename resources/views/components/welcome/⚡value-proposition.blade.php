<section id="valeur" class="py-24 px-5 border-y transition-colors duration-300"
         :class="dark ? 'bg-zinc-900/50 border-zinc-800' : 'bg-white border-zinc-200'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-14">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        La vérité que personne ne dit
      </div>
      <h2 class="font-display font-bold leading-tight mb-4" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Vous passez des heures à soigner votre CV.<br>
        <span class="grad-text">Les recruteurs le lisent en 6 secondes.</span>
      </h2>
      <p class="text-base max-w-lg mx-auto" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
        Ce n'est pas un jugement c'est une réalité structurelle. Avec des centaines de candidatures par poste, personne ne peut lire chaque CV en entier.
      </p>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-10">
      <!-- Mythe candidat -->
      <div class="reveal-l rounded-2xl border p-8 relative overflow-hidden"
           :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-zinc-50 border-zinc-200'">
        <div class="absolute top-4 right-4 text-xs font-bold px-3 py-1 rounded-full border"
             :class="dark ? 'bg-red-500/15 text-red-400 border-red-500/20' : 'bg-red-50 text-red-600 border-red-200'">
          Le mythe
        </div>
        <h3 class="font-display font-bold text-lg mb-4" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Ce que le candidat croit</h3>
        <ul class="space-y-3">
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Peaufiner chaque ligne du CV pendant des heures
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Écrire une lettre de motivation personnalisée
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Adapter le format, les mots-clés, la mise en page
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-red-400 shrink-0">✗</span>
            Attendre… et souvent ne jamais avoir de retour
          </li>
        </ul>
      </div>

      <!-- Réalité recruteur -->
      <div class="reveal-r rounded-2xl border p-8 relative overflow-hidden"
           :class="dark ? 'bg-zinc-900 border-zinc-800' : 'bg-zinc-50 border-zinc-200'">
        <div class="absolute top-4 right-4 text-xs font-bold px-3 py-1 rounded-full border"
             :class="dark ? 'bg-amber-500/15 text-amber-400 border-amber-500/20' : 'bg-amber-50 text-amber-600 border-amber-200'">
          La réalité
        </div>
        <h3 class="font-display font-bold text-lg mb-4" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Ce que le recruteur fait vraiment</h3>
        <ul class="space-y-3">
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Reçoit 200+ candidatures en 48h pour un seul poste
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Scanne le CV en 6 secondesshrink-0titre, entreprise, expérience
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Ignore la lettre de motivation dans 90 % des cas
          </li>
          <li class="flex items-start gap-3 text-sm" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">
            <span class="mt-0.5 text-amber-400 shrink-0">!</span>
            Élimine en masse par manque de temps, pas de critères clairs
          </li>
        </ul>
      </div>
    </div>

    <!-- Conclusion MatchRH -->
    <div class="reveal rounded-2xl border p-8 md:p-12 text-center relative overflow-hidden"
         :class="dark ? 'bg-emerald-950/40 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
      <div class="absolute inset-0 pointer-events-none"
           style="background:radial-gradient(ellipse 60% 80% at 50% 100%,rgba(52,211,153,.07),transparent)"></div>
      <div class="relative">
        <div class="text-xl text-center mb-4">
        <flux:icon.scale class="size-10  mx-auto"/>

        </div>
        <h3 class="font-display font-bold text-2xl mb-3" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
          MatchRH rend le jeu équitable
        </h3>
        <p class="text-base max-w-lg mx-auto mb-6" :class="dark ? 'text-zinc-400' : 'text-zinc-600'">
          Vos compétences réelles sont évaluées sur des critères objectifs et structurés pas sur la beauté d'un PDF. Le meilleur profil gagne, pas le meilleur CV designer.
        </p>
        <div class="flex flex-wrap gap-3 justify-center">
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Compétences notées /5</span>
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Expérience vérifiable</span>
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Score visible avant candidature</span>
          <span class="px-4 py-2 rounded-lg text-sm font-medium border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-300' : 'bg-emerald-100 border-emerald-300 text-emerald-700'">Pas de biais de présentation</span>
        </div>
      </div>
    </div>
  </div>
</section>
