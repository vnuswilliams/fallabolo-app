<section id="fonctionnalites" class="py-24 px-5 transition-colors duration-300"
         :class="dark ? 'bg-zinc-950' : 'bg-slate-50'">
  <div class="max-w-5xl mx-auto">

    <div class="reveal text-center mb-14">
      <div class="inline-block px-3 py-1 rounded-full border text-xs font-bold font-display uppercase tracking-widest mb-4"
           :class="dark ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-emerald-50 border-emerald-200 text-emerald-700'">
        Fonctionnalités
      </div>
      <h2 class="font-display font-bold leading-tight" style="font-size:clamp(1.8rem,4.5vw,3rem)"
          :class="dark ? 'text-zinc-100' : 'text-zinc-900'">
        Tout ce dont vous avez besoin,<br>rien de superflu
      </h2>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
      <div class="reveal d1 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.hand-raised class="size-8"/>
        </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Critères bloquants configurables</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Définissez vos exigences non-négociables. Tout le reste est auto-filtré avant même l'envoi de la candidature.</p>
      </div>
      <div class="reveal d2 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.star class="size-8"/>
        </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Système de bonus flexible</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Récompensez les compétences différenciantes avec des points bonus cumulables certifications, langues rares, expertises.</p>
      </div>
      <div class="reveal d3 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.chart-pie class="size-8"/>
        </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Classement automatique</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Les candidats arrivent déjà classés du plus compatible au moins compatible. Zéro tri manuel nécessaire.</p>
      </div>
      <div class="reveal d1 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.eye class="size-8"/>
        </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Score visible avant candidature</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Le candidat voit sa compatibilité avant de postuler. Il s'auto-sélectionne moins de candidatures, bien meilleures.</p>
      </div>
      <div class="reveal d2 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.bell class="size-8"/>
    </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Notifications temps réel</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Alertes instantanées à chaque candidature qualifiée. Résumés périodiques de l'activité de vos offres.</p>
      </div>
      <div class="reveal d3 p-6 rounded-2xl border transition-all duration-300 hover:-translate-y-1 cursor-default"
           :class="dark ? 'bg-zinc-900 border-zinc-800 hover:border-zinc-600 hover:bg-zinc-800/80' : 'bg-white border-zinc-200 hover:border-zinc-400 hover:bg-zinc-50'">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-5 border" :class="dark ? 'bg-emerald-500/10 border-emerald-500/20' : 'bg-emerald-50 border-emerald-200'">
        <flux:icon.sparkles class="size-8"/>
        </div>
        <h3 class="font-display font-bold text-sm mb-2" :class="dark ? 'text-zinc-100' : 'text-zinc-900'">Recommandations IA</h3>
        <p class="text-sm leading-relaxed" :class="dark ? 'text-zinc-400' : 'text-zinc-500'">Le système suggère proactivement des profils aux recruteurs et des offres adaptées aux candidats.</p>
      </div>
    </div>
  </div>
</section>
