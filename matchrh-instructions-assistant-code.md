# MatchRH — Instructions pour l’assistant de code

> Document de briefing technique — Usage interne  
> Version validée — Juin 2026

-----

## ⚠️ Instruction prioritaire — Ce que tu fais et ce que tu ne fais PAS

### Ce que tu fais dans cette phase

Tu construis le **UI scaffolding** de l’application : des vues Blade/Livewire complètes, visuellement fidèles au produit final, avec des **données fictives codées en dur** dans les vues pour simuler le comportement réel de l’application.

L’objectif est que le product owner puisse naviguer dans l’application, voir les dashboards, les formulaires, les listes, les scores — exactement comme si la plateforme était en production avec de vrais utilisateurs.

### Ce que tu ne fais PAS dans cette phase

- ❌ Aucune logique métier (pas de calcul de score, pas de matching)
- ❌ Aucune requête Eloquent réelle vers la base de données dans les vues
- ❌ Aucun Service Class, aucun Job, aucun Observer, aucun Event
- ❌ Aucune validation de formulaire côté serveur
- ❌ Aucune authentification réelle dans les composants (le middleware gère déjà ça)

### Ce que tu fais en base de données

- ✅ Tu crées toutes les migrations décrites dans ce document
- ✅ Tu crées les Seeders avec des données fictives réalistes pour le marché camerounais
- ✅ Tu crées les Models Eloquent avec leurs relations (sans logique métier)

-----

## 1. Contexte du projet

MatchRH est une plateforme de matching RH intelligente ciblant le marché camerounais (Douala et Yaoundé en priorité). Elle connecte recruteurs et candidats via un algorithme de compatibilité structuré, remplaçant les CV et lettres de motivation par des profils déclaratifs scorés.

**Stack :** Laravel 13, Livewire (starter kit officiel), Spatie Permission  
**Marché cible :** Cameroun — francophone/anglophone/bilingue  
**Langue de l’interface :** Français

-----

## 2. Modifications de la base de données existante

Les migrations existantes sont documentées dans `matchrh_migrations.md`. Ce document décrit uniquement les **modifications et ajouts** à apporter.

-----

### 2.1 Modification — `recruiter_profiles`

Ajouter une seule colonne :

```
is_managed_by → foreignId → nullable → FK users.id → onDelete set null
```

**Explication métier :**  
Cette colonne permet à un utilisateur (bénévole ou admin) de gérer le profil d’un recruteur tiers. Quand `is_managed_by` est `null`, le recruteur gère son propre profil — cas normal. Quand `is_managed_by` contient un `user_id`, ce profil est géré par cet utilisateur au nom de l’entreprise recruteur.

Un même utilisateur ne peut pas gérer plus de **10 profils recruteurs** via ce système. Cette contrainte est vérifiée à la création (logique métier — pas dans cette phase).

**Schéma de la relation :**

```
users (bénévole) ──── is_managed_by ──── recruiter_profiles (entreprise tierce)
```

**Aucune modification sur `job_offers`** — `recruiter_profile_id` reste l’unique référence propriétaire de l’offre.

-----

### 2.2 Modification — `recruiter_profiles`

Ajouter deux colonnes pour la gestion des suspensions :

```
is_suspended  → boolean   → NOT NULL → défaut false
suspended_at  → timestamp → nullable
```

-----

### 2.3 Modification — `candidate_profiles`

Ajouter les mêmes deux colonnes :

```
is_suspended  → boolean   → NOT NULL → défaut false
suspended_at  → timestamp → nullable
```

-----

### 2.4 Nouvelle table — `reports`

Système de signalement polymorphique — gère à la fois les signalements d’offres et de profils candidats dans une seule table.

|Colonne          |Type         |Contraintes               |Description                                           |
|-----------------|-------------|--------------------------|------------------------------------------------------|
|`id`             |bigIncrements|PK                        |                                                      |
|`reporter_id`    |foreignId    |NOT NULL, FK → `users.id` |Celui qui signale                                     |
|`reportable_type`|string       |NOT NULL                  |`App\Models\JobOffer` ou `App\Models\CandidateProfile`|
|`reportable_id`  |bigInteger   |NOT NULL                  |ID de l’élément signalé                               |
|`reason`         |enum         |NOT NULL                  |Voir valeurs ci-dessous                               |
|`comment`        |text         |nullable                  |Précision libre optionnelle                           |
|`status`         |enum         |NOT NULL, défaut `pending`|`pending`, `reviewed`, `dismissed`, `confirmed`       |
|`reviewed_by`    |foreignId    |nullable, FK → `users.id` |Admin qui a pris la décision                          |
|`reviewed_at`    |timestamp    |nullable                  |Date de décision admin                                |
|`created_at`     |timestamp    |nullable                  |                                                      |
|`updated_at`     |timestamp    |nullable                  |                                                      |

**Contrainte d’unicité :**

```
unique(['reporter_id', 'reportable_type', 'reportable_id'])
```

Un utilisateur ne peut signaler le même élément qu’une seule fois.

**Index à créer :**

```
index(['reportable_type', 'reportable_id'])
```

**Valeurs de l’enum `reason` :**

Pour une offre (`JobOffer`) :

- `fake_offer` — Offre fictive ou frauduleuse
- `misleading` — Informations trompeuses
- `discriminatory` — Offre discriminatoire
- `suspicious_contact` — Coordonnées suspectes
- `duplicate` — Doublon

Pour un profil candidat (`CandidateProfile`) :

- `false_info` — Informations manifestement fausses
- `inappropriate` — Comportement inapproprié
- `identity_theft` — Usurpation d’identité
- `spam` — Spam

> Les deux ensembles de raisons cohabitent dans le même enum. La vue filtre les raisons pertinentes selon le type d’élément signalé.

-----

### 2.5 Règle de suspension automatique (pour la phase logique métier — pas maintenant)

Un profil est automatiquement suspendu quand :

- **10 signalements** ont été soumis sur un de ses éléments (offre ou profil)
- **ET** ces signalements proviennent d’au moins **5 utilisateurs distincts**

Quand la suspension se déclenche :

- `is_suspended` passe à `true` sur le profil concerné
- `suspended_at` est horodaté
- Toutes les offres du recruteur sont masquées via Global Scope
- Le profil candidat suspendu disparaît des résultats de matching
- Une notification “compte sous examen” est envoyée au propriétaire — sans détail sur les signalants ni leur nombre

-----

### 2.6 Ordre des migrations mis à jour

```
01 → users
02 → tables Spatie Permission
03 → skills
04 → assets
05 → candidate_profiles          + is_suspended, suspended_at
06 → recruiter_profiles          + is_managed_by, is_suspended, suspended_at
07 → candidate_skills
08 → job_offers
09 → job_required_skills
10 → match_results
11 → applications
12 → reports                     ← nouvelle table
```

-----

## 3. Architecture de navigation — Deux espaces séparés

Le routing Laravel distingue deux espaces via middleware Spatie :

```
/recruteur/*   → middleware role:recruteur
/candidat/*    → middleware role:candidat
/admin/*       → middleware role:admin
```

Après connexion, la redirection est automatique selon le rôle :

- Recruteur → `/recruteur/dashboard`
- Candidat → `/candidat/dashboard`
- Admin → `/admin/dashboard`

-----

## 4. Parcours recruteur — Vues à construire

### 4.1 Première connexion — Onboarding

**Route :** `/recruteur/onboarding`  
**Déclencheur :** recruteur connecté sans `recruiter_profile` existant

Page épurée, pas de sidebar. Un seul objectif : compléter le profil entreprise avant d’accéder au dashboard.

**Données fictives à afficher :** aucune — c’est un formulaire vide.

**Champs du formulaire :**

- Nom de l’entreprise
- Secteur d’activité (liste déroulante)
- Téléphone de contact
- Ville (Douala / Yaoundé / Autre)
- Pays (défaut : Cameroun)

**Comportement UI :** formulaire en une seule étape, bouton “Accéder à mon espace” en bas.

-----

### 4.2 Dashboard recruteur — Connexions suivantes

**Route :** `/recruteur/dashboard`

#### Cas A — Dashboard vide (premier accès après onboarding)

Afficher un état vide engageant, pas une page blanche :

```
┌─────────────────────────────────────────────────────┐
│  Bienvenue sur MatchRH, TechCorp !                  │
│                                                      │
│  Publiez votre première offre et recevez             │
│  uniquement des candidats qualifiés.                 │
│                                                      │
│  [ + Publier une offre ]                             │
│                                                      │
│  ✓ Filtrage automatique des profils                  │
│  ✓ Score de compatibilité affiché sur chaque candidat│
│  ✓ Zéro CV à trier manuellement                     │
└─────────────────────────────────────────────────────┘
```

#### Cas B — Dashboard actif (données fictives codées en dur)

**Zone 1 — Cartes de synthèse (ligne du haut)**

|Carte                               |Valeur fictive|
|------------------------------------|--------------|
|Offres actives                      |3             |
|Candidatures non consultées         |7             |
|Nouveaux profils matchés aujourd’hui|4             |
|Offres en brouillon                 |1             |

**Zone 2 — Mes offres actives (tableau central)**

Afficher 3 offres fictives :

|Poste                     |Publiée le  |Candidats qualifiés|Meilleur score|Statut|Action        |
|--------------------------|------------|-------------------|--------------|------|--------------|
|Développeur Laravel Senior|02 juin 2026|12                 |94%           |Active|Voir candidats|
|Comptable Senior          |28 mai 2026 |5                  |87%           |Active|Voir candidats|
|Responsable RH            |15 mai 2026 |2                  |71%           |Active|Voir candidats|

**Zone 3 — Alertes (panneau latéral ou bandeau)**

```
🔔 4 nouveaux profils correspondent à votre offre "Développeur Laravel Senior"
🔔 Votre offre "Responsable RH" expire dans 5 jours
```

**Bouton permanent :** `+ Publier une nouvelle offre` — visible en haut à droite en permanence.

-----

### 4.3 Création d’offre — Wizard en 4 étapes

**Route :** `/recruteur/offres/creer`

Le formulaire est un wizard multi-étapes. Chaque étape est une page distincte avec indicateur de progression visible.

-----

#### Étape 1 — Contexte de publication

**Question centrale affichée :**  
*“Cette offre est-elle publiée au nom de votre entreprise ?”*

**Option A — Mon entreprise (sélectionnée par défaut)**  
Le nom de l’entreprise du recruteur connecté s’affiche en confirmation visuelle.  
`recruiter_profile_id` sera rempli automatiquement avec son propre profil.

**Option B — Je publie au nom d’une autre entreprise**  
Afficher une liste déroulante des profils recruteurs que cet utilisateur gère (`is_managed_by = user_id connecté`).  
Option supplémentaire : `+ Créer un nouveau profil entreprise` qui ouvre un mini-formulaire inline (nom, secteur, ville).

> ⚠️ En UI scaffolding : simuler l’option B avec 2-3 entreprises fictives dans la liste déroulante.

-----

#### Étape 2 — Informations générales

Champs :

- Intitulé du poste
- Template de poste (liste déroulante) :
  - Manœuvres & Ouvriers
  - Employés & Techniciens
  - Agents de maîtrise
  - Cadres
  - Cadres dirigeants & Dirigeants
- Description du poste (textarea)
- Ville
- Région
- Budget minimum (FCFA) — optionnel
- Budget maximum (FCFA) — optionnel
- Profil linguistique requis : Francophone / Anglophone / Bilingue (défaut : Bilingue)

-----

#### Étape 3 — Critères de sélection

**Bloc A — Critères bloquants (éliminatoires)**  
Chaque critère est une bascule on/off. Activé = éliminatoire.

- Niveau de formation minimum (liste déroulante — niveaux camerounais)
- Expérience minimum (paliers : sans / 1-2 ans / 3-4 ans / 5-10 ans / +10 ans)
- Disponibilité maximum acceptée
- Permis requis (A / B / C / D)

**Bloc B — Compétences requises**  
Interface d’ajout de compétences depuis la bibliothèque :

- Recherche dans la liste des compétences disponibles
- Pour chaque compétence ajoutée : curseur de niveau requis (1 à 5)
- Possibilité de retirer une compétence

> En UI scaffolding : afficher 4 compétences pré-remplies avec leurs niveaux (ex : Laravel 5/5, PHP 4/5, MySQL 3/5, Git 2/5).

**Bloc C — Atouts recherchés (bonus)**  
Sélection libre depuis la bibliothèque d’atouts :

- Expérience sectorielle (BTP, Banque, Santé, Télécoms…)
- Certifications (Sage Paie, PMP, CFA…)
- Compétences contextuelles (télétravail, management de projet…)
- Langues supplémentaires

Pour chaque atout : sélection de priorité (Faible / Moyen / Fort).

-----

#### Étape 4 — Récapitulatif et publication

Affichage en lecture seule de toutes les informations saisies aux étapes précédentes.

Deux boutons :

- `Enregistrer en brouillon`
- `Publier l'offre`

-----

### 4.4 Vue candidats d’une offre

**Route :** `/recruteur/offres/{id}/candidats`

Liste classée automatiquement par score décroissant.

**Données fictives à afficher :**

```
Jean Ekotto      — 94%   Atouts 3/5   Compétences supp. 2   [ Voir le profil ]
Marie Mballa     — 89%   Atouts 2/5   Compétences supp. 1   [ Voir le profil ]
Alain Nkodo      — 85%   Atouts 4/5   Compétences supp. 3   [ Voir le profil ]
Sophie Biyong    — 79%   Atouts 1/5   Compétences supp. 0   [ Voir le profil ]
Paul Essomba     — 71%   Atouts 2/5   Compétences supp. 1   [ Voir le profil ]
```

Chaque ligne est cliquable et ouvre le détail du profil candidat avec le score décomposé par bloc.

-----

### 4.5 Détail d’un candidat

**Route :** `/recruteur/offres/{offre_id}/candidats/{candidat_id}`

```
┌─────────────────────────────────────────────────┐
│  Jean Ekotto — Développeur Laravel              │
│  Douala, Cameroun                               │
├─────────────────────────────────────────────────┤
│  Compatibilité globale          94%             │
├─────────────────────────────────────────────────┤
│  Compétences                   88%   ✅          │
│  Expérience                   100%   ✅          │
│  Formation                     45%   ⚠️          │
│  Disponibilité                100%   ✅          │
│  Localisation                 100%   ✅          │
│  Salaire                      100%   ✅          │
├─────────────────────────────────────────────────┤
│  Atouts recherchés              3/5             │
│  → Expérience Télécoms      ✓  (Fort)           │
│  → Certification AWS        ✗                   │
│  → Expérience télétravail   ✓  (Moyen)          │
│  → Anglais professionnel    ✓  (Faible)         │
│  → Expérience en PME        ✗                   │
├─────────────────────────────────────────────────┤
│  Compétences supplémentaires    2               │
│  → Vue.js                                       │
│  → Docker                                       │
├─────────────────────────────────────────────────┤
│  [ Shortlister ]   [ Rejeter ]   [ Signaler ]   │
└─────────────────────────────────────────────────┘
```

-----

## 5. Parcours candidat — Vues à construire

### 5.1 Première connexion — Onboarding

**Route :** `/candidat/onboarding`  
**Déclencheur :** candidat connecté sans `candidate_profile` existant

Formulaire en plusieurs étapes courtes. L’objectif est que le candidat complète son profil avant de voir les offres.

**Étape 1 — Informations personnelles**

- Téléphone
- Ville
- Région
- Pays (défaut : Cameroun)
- Profil linguistique : Francophone / Anglophone / Bilingue

**Étape 2 — Parcours professionnel**

- Niveau de formation (liste déroulante — niveaux camerounais : Aucun / CEPC / BEPC / BAC / BTS / Licence / Master / Doctorat)
- Domaine d’études
- Expérience (paliers : sans expérience / 1-2 ans / 3-4 ans / 5-10 ans / plus de 10 ans)

**Étape 3 — Compétences**

- Ajout de compétences depuis la bibliothèque
- Pour chaque compétence : niveau déclaré (1 à 5)

**Étape 4 — Disponibilité & Prétentions**

- Disponibilité : Immédiate / 15 jours / 30 jours / Plus d’un mois
- Salaire minimum souhaité (FCFA) — optionnel
- Salaire maximum souhaité (FCFA) — optionnel
- Upload CV (optionnel — préciser que le système fonctionne sans)

-----

### 5.2 Dashboard candidat — Connexions suivantes

**Route :** `/candidat/dashboard`

#### Zone 1 — Barre de complétion du profil

Affichée en haut si le profil est incomplet.

```
Votre profil est complété à 70%
Ajoutez vos compétences pour apparaître dans plus d'offres.
[ Compléter mon profil ]
████████████░░░  70%
```

#### Zone 2 — Offres recommandées

**Si le profil est incomplet :** afficher les offres avec les scores floutés.

```
Développeur Laravel Senior — TechCorp — Douala
Compatibilité : ██████ Complétez votre profil pour voir votre score

Comptable Senior — FinGroup — Yaoundé  
Compatibilité : ██████ Complétez votre profil pour voir votre score
```

**Si le profil est complet :** afficher les scores réels (fictifs en dur).

```
Développeur Laravel Senior — TechCorp — Douala       92%  [ Voir l'offre ]
Développeur Full Stack — StartupCM — Douala           88%  [ Voir l'offre ]
Intégrateur Web — AgenceDig — Yaoundé                 81%  [ Voir l'offre ]
```

#### Zone 3 — Mes candidatures

```
Développeur Laravel Senior — TechCorp     Envoyée le 01/06/2026    En attente
Comptable Junior — BankCM                 Envoyée le 28/05/2026    Consultée ✓
```

-----

### 5.3 Liste des offres disponibles

**Route :** `/candidat/offres`

Liste paginée de toutes les offres compatibles, triées par score décroissant.

Chaque carte d’offre affiche :

- Intitulé du poste
- Nom de l’entreprise
- Ville
- Score de compatibilité (ou flouté si profil incomplet)
- Date de publication
- Bouton “Voir l’offre”

-----

### 5.4 Détail d’une offre — Vue candidat

**Route :** `/candidat/offres/{id}`

```
┌─────────────────────────────────────────────────┐
│  Développeur Laravel Senior                     │
│  TechCorp — Douala                              │
│  Publiée le 02 juin 2026                        │
├─────────────────────────────────────────────────┤
│  Compatibilité                      87%         │
├─────────────────────────────────────────────────┤
│  Compétences                       68%   ⚠️      │
│  Expérience                       100%   ✅      │
│  Formation                         45%   ⚠️      │
│  Disponibilité                    100%   ✅      │
│  Localisation                     100%   ✅      │
│  Salaire                          100%   ✅      │
├─────────────────────────────────────────────────┤
│  Atouts détectés sur votre profil   3/5         │
│  → Expérience secteur Télécoms  ✓               │
│  → Certification AWS            ✗               │
│  → Expérience télétravail       ✓               │
│  → Anglais professionnel        ✓               │
│  → Expérience en PME            ✗               │
├─────────────────────────────────────────────────┤
│  Compétences supplémentaires        2           │
│  → Vue.js                                       │
│  → Docker                                       │
├─────────────────────────────────────────────────┤
│  Description du poste                           │
│  [texte fictif de description]                  │
├─────────────────────────────────────────────────┤
│  [ Je suis intéressé ]      [ Signaler ]        │
└─────────────────────────────────────────────────┘
```

-----

## 6. Système de signalement — Vues à construire

### 6.1 Modal de signalement — Offre

Déclenché par le bouton “Signaler” sur la vue détail d’une offre.

**Titre :** “Signaler cette offre”

**Champs :**

- Raison (liste déroulante) :
  - Offre fictive ou frauduleuse
  - Informations trompeuses
  - Offre discriminatoire
  - Coordonnées suspectes
  - Doublon
- Commentaire (textarea — optionnel)
- Bouton `Envoyer le signalement`

-----

### 6.2 Modal de signalement — Profil candidat

Déclenché par le bouton “Signaler” sur la vue détail d’un candidat (côté recruteur).

**Titre :** “Signaler ce profil”

**Champs :**

- Raison (liste déroulante) :
  - Informations manifestement fausses
  - Comportement inapproprié
  - Usurpation d’identité
  - Spam
- Commentaire (textarea — optionnel)
- Bouton `Envoyer le signalement`

-----

### 6.3 Notification de suspension — Vue utilisateur suspendu

Quand un utilisateur suspendu se connecte, afficher une page bloquante à la place du dashboard :

```
┌─────────────────────────────────────────────────┐
│  Votre compte est actuellement sous examen      │
│                                                  │
│  Nous avons reçu des signalements concernant    │
│  votre compte ou vos publications.              │
│                                                  │
│  Notre équipe examine la situation. Vous serez  │
│  notifié par email dès qu'une décision sera     │
│  prise.                                          │
│                                                  │
│  Pour toute question : support@matchrh.cm       │
└─────────────────────────────────────────────────┘
```

-----

## 7. Seeders — Données fictives à créer

Les seeders doivent peupler la base avec des données réalistes pour le marché camerounais.

### Comptes utilisateurs

|Email               |Rôle     |Entreprise / Nom                |
|--------------------|---------|--------------------------------|
|`recruteur1@test.cm`|recruteur|TechCorp Douala                 |
|`recruteur2@test.cm`|recruteur|FinGroup Yaoundé                |
|`recruteur3@test.cm`|recruteur|AgenceDig Douala                |
|`candidat1@test.cm` |candidat |Jean Ekotto                     |
|`candidat2@test.cm` |candidat |Marie Mballa                    |
|`candidat3@test.cm` |candidat |Alain Nkodo                     |
|`admin@matchrh.cm`  |admin    |—                               |
|`benevole@test.cm`  |recruteur|gère 2 profils via is_managed_by|

Mot de passe universel pour tous les comptes de test : `password`

### Compétences à seeder (table `skills`)

Quelques exemples par catégorie :

**Développement :** Laravel, PHP, MySQL, JavaScript, Vue.js, React, Docker, Git, Python, Node.js

**Comptabilité/Finance :** Sage Comptabilité, Sage Paie, Excel avancé, OHADA, Gestion budgétaire

**RH :** Recrutement, Formation, Paie, SIRH, Gestion des conflits

**Vente/Marketing :** Prospection commerciale, CRM, Marketing digital, Community management

**Logistique :** Gestion des stocks, Transport, Supply chain, Douane

### Atouts à seeder (table `assets`)

**Sectoriel :** Expérience BTP, Expérience Banque, Expérience Santé, Expérience Télécoms, Expérience Agriculture

**Certification :** Certification PMP, Certification CFA, Certification AWS, Certification Sage Paie, OHSAS 18001

**Contextuel :** Expérience télétravail, Management d’équipe, Expérience PME, Expérience multinationale, Expérience internationale

**Langue supplémentaire :** Allemand, Espagnol, Chinois mandarin, Portugais

-----

## 8. Charte visuelle

L’identité visuelle de MatchRH est établie sur une esthétique **dark luxury** avec des accents or/ambre. Elle a été validée sur la landing page.

- **Fond principal :** sombre (near-black)
- **Accents :** or / ambre (`#D4AF37` ou équivalent)
- **Texte :** blanc cassé sur fonds sombres
- **Cartes et panneaux :** surfaces légèrement plus claires que le fond
- **Statuts positifs :** vert sobre (pas de vert fluo)
- **Statuts d’alerte :** ambre
- **Statuts négatifs :** rouge sobre
- **Typographie :** cohérente avec la landing page existante

**Cohérence obligatoire :** les dashboards et vues internes doivent être visuellement cohérents avec la landing page déjà validée.

-----

## 9. Rappel — Ce qui ne change pas

Tout ce qui est documenté dans `matchrh_migrations.md` reste intact. Ce document ne remplace pas ce fichier, il le complète.

Les décisions d’algorithme documentées dans `algorithme_matchrh.md` et `Méthode_de_calcul_algorithme_scoring_matchrh.md` ne sont pas implémentées dans cette phase. Les scores affichés dans les vues sont des valeurs fictives codées en dur.

-----

*MatchRH — Document confidentiel — Usage interne — Juin 2026*