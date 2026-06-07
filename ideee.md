# MEGA-PROMPT : PLATEFORME MATCHRH — GUIDELINES DE DÉVELOPPEMENT LARAVEL

-----

## 1. VISION ET PÉRIMÈTRE DU PROJET

Tu développes **fallabolo**, une plateforme SaaS de recrutement intelligent qui connecte recruteurs et candidats via un algorithme de matching automatique basé sur des critères structurés.

**Ce que la plateforme fait :**

- Calcule un score de compatibilité `candidat ↔ offre` en temps réel
- Élimine les candidats non qualifiés via des critères bloquants
- Classe les candidats qualifiés du plus au moins compatible
- Affiche le score au candidat AVANT qu’il postule
- Supprime CV et lettres de motivation du processus principal

**Ce que la plateforme ne fait PAS (MVP) :**

- Pas de messagerie interne entre recruteurs et candidats
- Pas de paiement en ligne automatisé (facturation manuelle en MVP)
- Pas d’IA générative dans le scoring (algorithme déterministe uniquement)

**Stack technique fixe — NE PAS suggérer d’alternatives :**

- **Backend & Frontend :** Laravel 13+ (Blade + Livewire4)
- **Base de données :** MySQL 8+
- **Cache & Queues :** database
- **Jobs asynchrones :** Laravel Queue (driver Redis)
- **Auth :** Laravel fortify
- **Email :** Laravel Mail + MailChimp (a voir avec l'evolution du projet)
- **Paiement :** optionnel MVP pas encore de methode de paiement gratuit pour le moment que ce soit pour le recruteur ou le candidat

-----

## 3. MODÈLE DE DONNÉES — MIGRATIONS LARAVEL

### Table `users` (Laravel standard)

```php
// Champs additionnels à ajouter via migration
$table->string('role')->after('email'); //sera un enum 
```

pour ce qui est des autrres tables nous evoluerons au fur et a mesure et creer les migrations necessaires enfonction des besoin et de l'evolution


## 4. L’ALGORITHME DE MATCHING — RÈGLES ABSOLUES

> ⚠️ L’algorithme est le cœur compétitif de MatchRH. Ces règles ne sont JAMAIS contournées.

### Architecture en 3 couches

**Couche 1 — Critères bloquants** (`BlockingCriteriaChecker.php`)

- Vérifiés en premier, avant tout calcul
- Si UN SEUL critère échoue → `score = 0`, `blocked = true`, processus terminé
- Exemples : langue, permis, diplôme minimum, disponibilité maximale

**Couche 2 — Score principal pondéré** (`ScoreCalculator.php`)

- Score entre 0% et 100%
- Formule : `score_bloc = e^(-λ × écart)` (pénalité exponentielle)
- Les pondérations et les lambda sont **fixes par template** — le recruteur ne peut pas les modifier
- Blocs : Compétences, Expérience, Formation, Disponibilité, Localisation, Salaire

**Couche 3 — Atouts** (`BonusDetector.php`)

- N’entre dans AUCUN calcul de score
- Affichage informatif uniquement
- Deux catégories : atouts recherchés (définis recruteur) + compétences supplémentaires (auto-détectées)

### Les 5 templates — Pondérations et Lambda

|Bloc             |Manœuvre  |Technicien|Agent maîtrise|Cadre     |Dirigeant |
|-----------------|----------|----------|--------------|----------|----------|
|**Compétences**  |30% / λ0.2|45% / λ0.4|40% / λ0.6    |35% / λ0.8|25% / λ1.0|
|**Expérience**   |25% / λ0.2|25% / λ0.4|30% / λ0.6    |35% / λ0.8|45% / λ1.0|
|**Formation**    |5% / λ0.2 |10% / λ0.4|10% / λ0.6    |15% / λ0.8|15% / λ1.0|
|**Disponibilité**|20% / λ0.1|10% / λ0.1|8% / λ0.2     |4% / λ0.2 |3% / λ0.3 |
|**Localisation** |15% / λ0.1|5% / λ0.1 |7% / λ0.2     |3% / λ0.2 |2% / λ0.3 |
|**Salaire**      |5% / λ0.1 |5% / λ0.1 |5% / λ0.2     |8% / λ0.3 |10% / λ0.4|

### Calcul du bloc compétences (pondération par niveau requis)

```
score_compétence_i = e^(-λ × max(0, niveau_requis_i - niveau_candidat_i))
score_bloc = Σ(score_compétence_i × niveau_requis_i) / Σ(niveau_requis_i)
```

### Calcul du bloc salaire

```
chevauchement = min(budget_max, salary_max) - max(budget_min, salary_min)
Si chevauchement ≥ 0 → score 100%
Si salary_max < budget_min → score 100% (recruteur peut négocier à la hausse)
Si chevauchement < 0 → écart_normalisé = |chevauchement| / budget_max
                       score = e^(-λ × écart_normalisé)
```

### Règles d’implémentation obligatoires

- Les constantes lambda et les pondérations doivent être dans des **fichiers de config** (`config/matching.php`), pas en dur dans le code
- Le `MatchingEngine` doit être invocable en **synchrone** (pour affichage immédiat du score) ET en **asynchrone** via `CalculateMatchScoreJob`
- Le détail du calcul par bloc est **stocké en JSON** dans `applications.score_detail` pour l’affichage côté recruteur et candidat
- **Jamais exposer** les valeurs de lambda ou les formules dans les vues Blade ou les réponses JSON publiques

-----

## 5. FONCTIONNALITÉS DÉTAILLÉES ET RÈGLES MÉTIER


```php
// routes/web.php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('role:recruiter')->prefix('recruteur')->group(...);
    Route::middleware('role:candidate')->prefix('candidat')->group(...);
});
```

-----

### Module 5.2 — Profils Utilisateurs

**Candidat — Champs obligatoires pour activer le matching :**

- Prénom, Nom, Ville, Pays
- Au moins 1 compétence avec niveau
- Palier d’expérience
- Niveau de formation
- Disponibilité
- Mode langue (francophone / anglophone / bilingue)

**Recruteur — Champs obligatoires pour publier une offre :**

- Nom de l’entreprise, Ville, Pays
- L’offre elle-même doit avoir au moins 1 compétence requise et 1 critère bloquant


-----

### Module 5.3 — Offres d’Emploi

**Création d’offre — Étapes (wizard multi-step recommandé avec Livewire) :**

1. Choix du template de poste (détermine pondérations et lambda)
1. Informations générales (titre, description, localisation, salaire, langue)
1. Compétences requises (sélection depuis bibliothèque + niveau 1-5)
1. Critères bloquants (sélection depuis bibliothèque + valeur si applicable)
1. Atouts recherchés / bonus (optionnel, depuis bibliothèque + priorité)
1. Récapitulatif → Publication

**Règles métier :**

- Un recruteur FREE peut publier **2 offres actives** simultanément (pour le moment peut mettre des offres illimites jusqua ce que les regles soit valider)
- Un recruteur PRO : **illimité**
- Une offre publiée déclenche automatiquement le calcul de matching (`CalculateMatchScoreJob::dispatch($jobOffer)`)
- Une offre fermée (`status = closed`) n’apparaît plus dans les résultats candidats

-----

### Module 5.4 — Candidature et Matching

**Flux de candidature côté candidat :**

1. Candidat browse les offres → score de compatibilité affiché sur la card
1. Candidat ouvre le détail → score détaillé par bloc + atouts détectés
1. Candidat clique “Je suis intéressé” → validation des critères bloquants en temps réel
1. Si tous les bloquants OK → candidature enregistrée dans `applications`
1. Recruteur notifié par email groupé (digest quotidien)

**Flux de consultation côté recruteur :**

- Dashboard offre → liste des candidatures classées par `score_principal DESC`
- Affichage : nom (anonymisé en FREE), score %, atouts détectés, statut
- Recruteur PRO : nom complet + contact + détail complet du score

**Règles métier importantes :**

- Le score est calculé une fois à la candidature et **stocké** — il n’est pas recalculé à chaque consultation
- Si le candidat met à jour son profil APRÈS avoir postulé, le score n’est PAS automatiquement mis à jour (le score reflète le profil au moment de la candidature)
- Un candidat ne peut pas postuler deux fois à la même offre (`UNIQUE` constraint)

-----

### Module 5.5 — Notifications

**Events & Listeners Laravel (ne pas utiliser de package tiers en MVP) :**

|Event                 |Listener                         |Déclencheur         |
|----------------------|---------------------------------|--------------------|
|`ApplicationSubmitted`|`NotifyRecruiterOfNewApplication`|Nouvelle candidature|
|`JobOfferPublished`   |`CalculateInitialMatches`        |Publication d’offre |
|`UserRegistered`      |`SendWelcomeEmail`               |Inscription         |

**Notifications email :**

- Digest quotidien recruteur (résumé des nouvelles candidatures qualifiées du jour)
- Email de bienvenue candidat avec guide de completion de profil
- Rappel recruteur si offre publiée depuis 7j sans candidature qualifiée

**Implémentation :**

```php
// Utiliser Laravel Notifications avec le channel 'mail'
// Scheduler dans app/Console/Kernel.php
$schedule->job(new SendRecruiterDailyDigest)->dailyAt('08:00');
```

-----

### Module 5.6 — Freemium & Abonnements

**Plans MVP (pour le moment illimite je suis en MVP) :**

|Feature                    |Gratuit|Pro (49 000 FCFA/mois)|Entreprise|
|---------------------------|-------|----------------------|----------|
|Offres actives             |2      |Illimité              |Illimité  |
|Candidatures visibles/offre|10     |Illimité              |Illimité  |
|Identité candidats         |Masquée|Complète              |Complète  |
|Détail score par bloc      |Non    |Oui                   |Oui       |
|Export CSV                 |Non    |Oui                   |Oui       |
|Support                    |Email  |Prioritaire           |Dédié     |

**Implémentation Laravel :**

- `CheckSubscriptionLimit` middleware vérifie le plan avant chaque action limitée
- Middleware injecte `$user->subscription` via `with()` dans le controller
- En MVP : facturation manuelle → `subscription.plan` mis à jour manuellement par admin
- Prévoir `SubscriptionService::upgrade($user, $plan)` pour future intégration Cashier/Stripe

-----

## 6. SÉCURITÉ — RÈGLES NON NÉGOCIABLES

### Validation

- **Toujours** utiliser des `livewire Form` pour tous les formulaires — jamais valider dans le controller

### Autorisation

- Utiliser les **Laravel Policies** pour toute action sur une ressource (ex: `JobOfferPolicy::update`)
- Un recruteur ne voit JAMAIS les offres ou données d’un autre recruteur
- Un candidat ne voit JAMAIS les données d’un autre candidat
- Vérification dans les policies : `$user->id === $recruiterProfile->user_id`

### Protection des données (Loi camerounaise 2024)

- Les données candidats sont déclaratives — l’afficher clairement dans les CGU
- Permettre la suppression de compte → anonymiser `candidate_profiles` (name → “Utilisateur supprimé”, email → null)
- Ne pas logger les scores et détails de matching dans les fichiers de log Laravel

### Sécurité générale

- CSRF activé par défaut sur toutes les routes web (ne pas désactiver)
- Rate limiting sur les routes d’auth et de candidature
- `APP_ENV=production` et `APP_DEBUG=false` en production — vérifier avant déploiement
- Headers de sécurité dans la config Nginx (X-Frame-Options, X-Content-Type-Options, etc.)

### Queues pour les calculs lourds

```php
// Dispatcher le calcul en queue — ne jamais bloquer la requête HTTP
CalculateMatchScoreJob::dispatch($jobOffer)
    ->delay(now()->addSeconds(5)); // Petit délai pour laisser la transaction se finaliser
```

-----

## 8. DESIGN SYSTEM — IDENTITÉ VISUELLE

### Typographie

```css
/* Titres : Cormorant Garamond (élégance) */
/* Corps : DM Sans (lisibilité) */
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@400;500;600&display=swap');

body { font-family: 'DM Sans', sans-serif; }
h1, h2, h3 { font-family: 'Cormorant Garamond', serif; }
```

### Composant score — Affichage cohérent

Le score doit toujours être affiché avec :

- Le pourcentage en grand (chiffre principal)
- Une couleur sémantique (vert/ambre/rouge)
- Le détail par bloc en dessous (recruteur PRO uniquement)
- Les atouts en section séparée avec icônes ✓ / ✗

-----

## 9. CONVENTIONS DE CODE LARAVEL

### Nommage

- **Routes** : kebab-case (`/offres-emploi/{id}`)
- **Variables** : camelCase dans PHP, snake_case dans les migrations et colonnes DB
- **Routes nommées** : `recruiter.offers.index`, `candidate.profile.edit`


### Services — Responsabilité unique

Chaque service que tu creer dois avoir une responsbilite unique ne pas le surcharger avec differentes logique 

-----

*MatchRH — Document confidentiel — Usage interne — Juin 2026*
