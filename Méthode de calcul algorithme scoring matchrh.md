# Algorithme de Scoring MatchRH

### Méthode de calcul officielle — Documentation technique complète

> Document confidentiel — Usage interne — Juin 2026

-----

## Table des matières

1. [Architecture générale](#1-architecture-générale)
1. [La méthode exponentielle](#2-la-méthode-exponentielle)
1. [Le paramètre Lambda](#3-le-paramètre-lambda)
1. [Les 5 templates et leurs pondérations](#4-les-5-templates-et-leurs-pondérations)
1. [Calcul détaillé de chaque bloc](#5-calcul-détaillé-de-chaque-bloc)
1. [Agrégation finale](#6-agrégation-finale)
1. [Couche 3 — Atouts](#7-couche-3--atouts)
1. [Affichage final](#8-affichage-final)
1. [Principes fondamentaux](#9-principes-fondamentaux-non-négociables)
1. [Simulation complète](#10-simulation-complète)

-----

## 1. Architecture générale

Le scoring MatchRH repose sur **3 couches successives**. Chaque couche ne s’active que si la précédente est franchie.

```
┌──────────────────────────────────────────────────┐
│         COUCHE 1 — Critères bloquants             │
│         Vérification éliminatoire                 │
│         Échec → Score = 0 → Fin du processus      │
└─────────────────────┬────────────────────────────┘
                      │ Succès
                      ▼
┌──────────────────────────────────────────────────┐
│         COUCHE 2 — Score principal                │
│         Calculé bloc par bloc puis agrégé         │
│         Résultat : valeur entre 0% et 100%        │
└─────────────────────┬────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────┐
│         COUCHE 3 — Atouts                         │
│         Purement informatif — aucun calcul        │
│         Atouts recherchés X/Y                     │
│         Compétences supplémentaires X             │
└──────────────────────────────────────────────────┘
```

### Couche 1 — Critères bloquants

- Vérifiés **en premier**, avant tout calcul
- Si **un seul** critère bloquant échoue → `score = 0`, processus terminé
- Définis par le recruteur à la création de l’offre (bibliothèque structurée)
- Exemples : Bilingue obligatoire, Minimum Licence, Permis B, Disponible sous 30 jours

### Couche 2 — Score principal

- Score calculé sur **100 points maximum**
- Pondérations **fixes**, non modifiables par le recruteur
- Les pondérations varient selon le **template de poste** choisi
- Chaque bloc applique une **pénalité exponentielle graduelle**

### Couche 3 — Atouts

- Ne rentre dans **aucun calcul**
- Affichage informatif uniquement — enrichit la lecture humaine du score
- Deux catégories : atouts contextuels recherchés + compétences supplémentaires

-----

## 2. La méthode exponentielle

### Pourquoi ce choix

Trois méthodes ont été évaluées sur le même exemple (compétence requise 4/5) :

|Candidat      |Linéaire|Paliers|**Exponentielle**|
|--------------|--------|-------|-----------------|
|5/5 (dépasse) |100%    |100%   |**100%**         |
|4/5 (parfait) |100%    |100%   |**100%**         |
|3/5 (écart -1)|75%     |70%    |**61%**          |
|1/5 (écart -3)|25%     |0%     |**22%**          |

- **Linéaire** : trop mécanique, chaque écart coûte le même pourcentage
- **Paliers** : arbitraire, seuils fixes peu nuancés
- **Exponentielle** : retenue car plus l’écart est grand, plus la pénalité s’accélère — correspond à la réalité RH

### La formule universelle

```
score_bloc = e^(-λ × écart)
```

|Variable    |Signification                                                 |
|------------|--------------------------------------------------------------|
|`e`         |Constante mathématique ≈ 2.718                                |
|`λ` (lambda)|Coefficient de sévérité — varie selon le template et le bloc  |
|`écart`     |Différence entre exigence offre et niveau candidat (minimum 0)|

### Règles fondamentales

- Candidat **dépasse** l’exigence → écart = 0 → score **100%** (pas de sur-score)
- Candidat **en dessous** → écart positif → pénalité graduelle
- Un candidat reste **toujours visible** dans les résultats (MatchRH n’est pas un outil de décision finale)

-----

## 3. Le paramètre Lambda

### Principe — Deux dimensions

Le lambda varie selon **deux dimensions simultanées** :

**Dimension 1 — Le template de poste**
Plus le poste est élevé dans la hiérarchie, plus les écarts sont pénalisés sévèrement.
Un manœuvre peut apprendre sur le tas. Un cadre dirigeant, non.

**Dimension 2 — Le type de bloc**

- Blocs à **fort poids** (Compétences, Expérience, Formation) → lambda du template
- Blocs à **faible poids** (Disponibilité, Localisation, Salaire) → lambda réduit car ces critères sont négociables

### Tableau des lambda par bloc et par template

|Bloc         |Manœuvre|Technicien|Agent maîtrise|Cadre|Dirigeant|
|-------------|--------|----------|--------------|-----|---------|
|Compétences  |0.2     |0.4       |0.6           |0.8  |1.0      |
|Expérience   |0.2     |0.4       |0.6           |0.8  |1.0      |
|Formation    |0.2     |0.4       |0.6           |0.8  |1.0      |
|Disponibilité|0.1     |0.1       |0.2           |0.2  |0.3      |
|Localisation |0.1     |0.1       |0.2           |0.2  |0.3      |
|Salaire      |0.1     |0.1       |0.2           |0.3  |0.4      |

### Effet concret du lambda — Écart de 1 niveau

|Lambda|Score obtenu|Contexte                           |
|------|------------|-----------------------------------|
|0.1   |90%         |Bloc secondaire, poste peu qualifié|
|0.2   |82%         |Bloc secondaire ou poste ouvrier   |
|0.4   |67%         |Bloc principal, poste technicien   |
|0.6   |55%         |Bloc principal, agent de maîtrise  |
|0.8   |45%         |Bloc principal, cadre              |
|1.0   |37%         |Bloc principal, cadre dirigeant    |

-----

## 4. Les 5 templates et leurs pondérations

Le recruteur choisit un template **au début de la création de l’offre**. Ce choix détermine automatiquement :

- Les **poids** de chaque bloc dans le calcul du score
- Les **lambda** appliqués à chaque bloc

-----

### Template 1 — Manœuvres & Ouvriers

*Philosophie : souplesse maximale — La formation n’est jamais bloquante. Accent sur la présence physique et la disponibilité.*

|Bloc         |Poids   |Lambda|
|-------------|--------|------|
|Compétences  |30%     |0.2   |
|Expérience   |25%     |0.2   |
|Disponibilité|20%     |0.1   |
|Localisation |15%     |0.1   |
|Formation    |5%      |0.2   |
|Salaire      |5%      |0.1   |
|**Total**    |**100%**|      |

-----

### Template 2 — Employés & Techniciens

*Philosophie : souplesse modérée — Les compétences techniques priment. Un autodidacte expérimenté peut compenser un niveau de formation inférieur.*

|Bloc         |Poids   |Lambda|
|-------------|--------|------|
|Compétences  |45%     |0.4   |
|Expérience   |25%     |0.4   |
|Formation    |10%     |0.4   |
|Disponibilité|10%     |0.1   |
|Localisation |5%      |0.1   |
|Salaire      |5%      |0.1   |
|**Total**    |**100%**|      |

-----

### Template 3 — Agents de maîtrise

*Philosophie : équilibre — Profil charnière entre exécution et encadrement. L’expérience commence à peser autant que les compétences.*

|Bloc         |Poids   |Lambda|
|-------------|--------|------|
|Compétences  |40%     |0.6   |
|Expérience   |30%     |0.6   |
|Formation    |10%     |0.6   |
|Disponibilité|8%      |0.2   |
|Localisation |7%      |0.2   |
|Salaire      |5%      |0.2   |
|**Total**    |**100%**|      |

-----

### Template 4 — Cadres

*Philosophie : rigueur — Expérience et compétences à égalité. La formation valide la légitimité académique. Le salaire devient un critère sérieux.*

|Bloc         |Poids   |Lambda|
|-------------|--------|------|
|Compétences  |35%     |0.8   |
|Expérience   |35%     |0.8   |
|Formation    |15%     |0.8   |
|Salaire      |8%      |0.3   |
|Disponibilité|4%      |0.2   |
|Localisation |3%      |0.2   |
|**Total**    |**100%**|      |

-----

### Template 5 — Cadres dirigeants & Dirigeants

*Philosophie : exigence maximale — L’expérience domine tout. Les compétences sont présupposées. La formation et le salaire sont des signaux de positionnement.*

|Bloc         |Poids   |Lambda|
|-------------|--------|------|
|Expérience   |45%     |1.0   |
|Compétences  |25%     |1.0   |
|Formation    |15%     |1.0   |
|Salaire      |10%     |0.4   |
|Disponibilité|3%      |0.3   |
|Localisation |2%      |0.3   |
|**Total**    |**100%**|      |

-----

## 5. Calcul détaillé de chaque bloc

-----

### 5.1 Bloc Compétences

**Échelle :** 1 à 5 pour chaque compétence (candidat et offre)

#### Étape 1 — Score par compétence individuelle

```
score_compétence = e^(-λ × écart)
écart = max(0, niveau_requis - niveau_candidat)
```

> Si le candidat dépasse le niveau requis → écart = 0 → score 100%

#### Étape 2 — Agrégation par moyenne pondérée

Les compétences ne sont **pas toutes égales** : une compétence requise à 5/5 est plus critique qu’une compétence requise à 2/5. On pondère donc par le niveau requis.

```
score_bloc_compétences = Σ(score_compétence × niveau_requis) / Σ(niveau_requis)
```

**Exemple (Template Cadre, λ = 0.8) :**

|Compétence|Requis|Candidat|Écart|Score         |Poids|
|----------|------|--------|-----|--------------|-----|
|Laravel   |5     |4       |1    |e^(-0.8) = 45%|5    |
|PHP       |4     |4       |0    |100%          |4    |
|MySQL     |3     |2       |1    |e^(-0.8) = 45%|3    |
|Git       |2     |3       |0    |100%          |2    |

```
Score = (45%×5 + 100%×4 + 45%×3 + 100%×2) / (5+4+3+2)
Score = (225 + 400 + 135 + 200) / 14
Score = 960 / 14 = 68.6%
```

#### Cas particuliers

|Situation                                         |Traitement                                                       |
|--------------------------------------------------|-----------------------------------------------------------------|
|Compétence requise, absente du profil candidat    |Niveau candidat = 0 → écart maximal → pénalité forte             |
|Compétence présente chez le candidat, non demandée|Ignorée ici → traitée en Couche 3 comme compétence supplémentaire|

-----

### 5.2 Bloc Expérience

**Pourquoi des paliers et non des années brutes :**
La différence entre 1 an et 2 ans est énorme. La différence entre 11 ans et 13 ans est négligeable. Les paliers socioprofessionnels capturent cette réalité naturellement.

**Échelle par paliers :**

|Palier|Libellé        |
|------|---------------|
|0     |Sans expérience|
|1     |1 à 2 ans      |
|2     |3 à 4 ans      |
|3     |5 à 10 ans     |
|4     |Plus de 10 ans |

```
score_expérience = e^(-λ × écart_palier)
```

> Si le candidat dépasse le palier requis → écart = 0 → score 100%
> L’excès d’expérience peut être valorisé via un atout défini par le recruteur en Couche 3.

-----

### 5.3 Bloc Formation

**Échelle ordinale — Contexte camerounais :**

|Diplôme      |Valeur numérique|
|-------------|----------------|
|Aucun diplôme|0               |
|CEPC         |1               |
|BEPC         |2               |
|BAC          |3               |
|BTS / DUT    |4               |
|Licence      |5               |
|Master       |6               |
|Doctorat     |7               |

```
score_formation = e^(-λ × écart_ordinal)
écart = max(0, valeur_requise - valeur_candidat)
```

**Exemple :** Requis Master (6), candidat Licence (5) → écart = 1 → `e^(-0.8×1)` = **45%**

-----

### 5.4 Bloc Disponibilité

**Échelle par paliers :**

|Palier|Libellé       |
|------|--------------|
|0     |Immédiate     |
|1     |15 jours      |
|2     |30 jours      |
|3     |Plus d’un mois|

```
score_disponibilité = e^(-λ_réduit × écart_palier)
```

> Si le candidat est disponible **plus tôt** que demandé → écart = 0 → score 100%

-----

### 5.5 Bloc Localisation

**Échelle de proximité :**

|Palier|Situation     |
|------|--------------|
|0     |Même ville    |
|1     |Même région   |
|2     |Même pays     |
|3     |Pays différent|

```
score_localisation = e^(-λ_réduit × écart_proximité)
```

-----

### 5.6 Bloc Salaire

**Variables en jeu :**

```
Recruteur déclare : Budget_min  —  Budget_max
Candidat déclare  : Salaire_min —  Salaire_max
```

#### Cas où le bloc est ignoré

|Recruteur      |Candidat       |Traitement                            |
|---------------|---------------|--------------------------------------|
|N’a pas déclaré|A déclaré      |Bloc ignoré — poids redistribué       |
|A déclaré      |N’a pas déclaré|Candidat = Négociable → **score 100%**|
|Aucun des deux |—              |Bloc ignoré — poids redistribué       |

#### Calcul quand les deux ont déclaré

**Étape 1 — Calcul du chevauchement**

```
chevauchement = min(Budget_max, Salaire_max) - max(Budget_min, Salaire_min)
```

**Étape 2 — Application selon le résultat**

|Situation                                         |Score                               |
|--------------------------------------------------|------------------------------------|
|Chevauchement ≥ 0 (fourchettes se croisent)       |100%                                |
|Salaire_max candidat < Budget_min recruteur       |100% (recruteur négocie à la hausse)|
|Chevauchement < 0 (fourchettes ne se croisent pas)|Pénalité calculée                   |

**Étape 3 — Calcul de la pénalité si chevauchement négatif**

```
écart_normalisé = |chevauchement| / Budget_max_recruteur
score_salaire   = e^(-λ_réduit × écart_normalisé)
```

> La normalisation par `Budget_max` évite de comparer des montants bruts en FCFA.
> On travaille sur des **ratios** indépendants des montants absolus.

-----

## 6. Agrégation finale

### Formule

```
Score_Principal = Σ (score_bloc × poids_template)
```

### Exemple complet — Template Cadre

```
Score = (score_compétences × 35%)
      + (score_expérience  × 35%)
      + (score_formation   × 15%)
      + (score_salaire     ×  8%)
      + (score_disponibilité × 4%)
      + (score_localisation  × 3%)
```

### Redistribution des poids si un bloc est ignoré

Quand le bloc Salaire est ignoré (non déclaré), son poids de 8% est redistribué proportionnellement aux autres blocs selon leurs poids respectifs.

**Résultat :** une valeur unique entre **0% et 100%**

-----

## 7. Couche 3 — Atouts

### Principe fondamental

Les atouts **ne rentrent dans aucun calcul**. Ils sont affichés séparément pour enrichir la lecture humaine. Le recruteur garde le contrôle de l’interprétation.

-----

### 7.1 Atouts recherchés (définis par le recruteur)

Le recruteur sélectionne des atouts dans la **bibliothèque MatchRH** et leur attribue une priorité.

|Priorité|Signification                 |
|--------|------------------------------|
|Faible  |Atout mineur, agréable à avoir|
|Moyen   |Atout réel, valorisé          |
|Fort    |Atout important, très valorisé|

Affichage : **X/Y** (atouts du candidat / atouts demandés)

```
Atouts recherchés : 3/5
→ Expérience secteur Télécoms   ✓  (Fort)
→ Certification AWS             ✗
→ Expérience télétravail        ✓  (Moyen)
→ Anglais professionnel         ✓  (Faible)
→ Expérience en PME             ✗
```

**Catégories de la bibliothèque :**

|Catégorie                |Exemples                                           |
|-------------------------|---------------------------------------------------|
|Expérience sectorielle   |BTP, Banque, Santé, Télécoms, Agriculture          |
|Certifications           |Sage Paie, PMP, CFA, OHSAS                         |
|Compétences contextuelles|Télétravail, Management de projet, Gestion d’équipe|
|Langues supplémentaires  |Allemand, Espagnol, Chinois                        |
|Profil atypique          |Double compétence, Expérience internationale       |

-----

### 7.2 Compétences supplémentaires (détectées automatiquement)

Compétences présentes dans le profil candidat **non demandées** par l’offre. Détectées et listées automatiquement par la plateforme.

Affichage : **nombre + liste**

```
Compétences supplémentaires : 2
→ Vue.js
→ Docker
```

-----

### 7.3 Départage en cas d’égalité de score

Quand deux candidats ont le même score principal, le recruteur s’appuie sur les atouts pour trancher :

```
Jean Dupont   — 94%   Atouts 3/5   Compétences supp. 3
Marie Ekoto   — 94%   Atouts 3/5   Compétences supp. 1
Alain Mbarga  — 94%   Atouts 2/5   Compétences supp. 4
```

Le recruteur interprète selon son contexte — MatchRH ne décide pas.

-----

## 8. Affichage final

### Vue candidat — Avant de postuler

```
┌─────────────────────────────────────────────────┐
│  Offre : Développeur Laravel Senior — TechCorp   │
├─────────────────────────────────────────────────┤
│  Compatibilité                      80.75%       │
├─────────────────────────────────────────────────┤
│  Compétences                        68.6%        │
│  Expérience                        100.0%        │
│  Formation                          45.0%        │
│  Disponibilité                     100.0%        │
│  Localisation                      100.0%        │
│  Salaire                           100.0%        │
├─────────────────────────────────────────────────┤
│  Atouts recherchés                   3/5         │
│  → Expérience secteur Télécoms   ✓               │
│  → Certification AWS             ✗               │
│  → Expérience télétravail        ✓               │
│  → Anglais professionnel         ✓               │
│  → Expérience en PME             ✗               │
├─────────────────────────────────────────────────┤
│  Compétences supplémentaires          2          │
│  → Vue.js                                        │
│  → Docker                                        │
└─────────────────────────────────────────────────┘
```

### Vue recruteur — Liste classée

```
┌──────────────────────────────────────────────────────────┐
│  Jean Dupont    — 87%   Atouts 3/5   Compétences supp. 2 │
│  Marie Ekoto    — 83%   Atouts 2/5   Compétences supp. 1 │
│  Alain Mbarga   — 79%   Atouts 4/5   Compétences supp. 3 │
└──────────────────────────────────────────────────────────┘
```

-----

## 9. Principes fondamentaux non négociables

|Principe                      |Description                                                                                                                  |
|------------------------------|-----------------------------------------------------------------------------------------------------------------------------|
|**Outil d’aide à la décision**|MatchRH ne décide pas. L’entretien reste l’étape de validation humaine indispensable.                                        |
|**Score relatif**             |Le score n’existe que dans la relation `candidat ↔ offre`. Un même candidat obtiendra des scores différents selon les offres.|
|**Toujours visible**          |Aucun candidat n’est masqué. Seuls les critères bloquants éliminent. Un score bas reste visible.                             |
|**Déclaratif assumé**         |Toutes les données sont auto-déclarées. La vérification appartient au recruteur via l’entretien.                             |
|**Pondérations protégées**    |Les poids et les lambda sont la propriété de MatchRH. Le recruteur ne peut pas les modifier.                                 |
|**Pas de sur-score**          |Dépasser une exigence ne rapporte aucun point supplémentaire dans le score principal.                                        |
|**Pénalité graduelle**        |Un écart pénalise proportionnellement — il ne tue jamais une candidature sauf critère bloquant.                              |
|**Atouts informatifs**        |Les atouts n’entrent dans aucun calcul. Ils enrichissent la lisibilité sans distordre le score.                              |

-----

## 10. Simulation complète

Voici une simulation de bout en bout pour valider l’enchaînement de toutes les formules.

### Données de l’offre

- **Poste :** Développeur Laravel Senior
- **Template :** Cadre (λ principal = 0.8, λ réduit = 0.2-0.3)
- **Critères bloquants :** Bilingue (FR+EN), Minimum Licence
- **Compétences requises :** Laravel 5/5, PHP 4/5, MySQL 3/5, Git 2/5
- **Expérience requise :** 3 à 4 ans (palier 2)
- **Formation requise :** Master (valeur 6)
- **Disponibilité requise :** 30 jours (palier 2)
- **Localisation :** Douala
- **Budget :** 400 000 — 600 000 FCFA

### Profil candidat — Jean Ekotto

- **Compétences :** Laravel 4/5, PHP 4/5, MySQL 2/5, Git 3/5, Vue.js 3/5 (non demandé), Docker 2/5 (non demandé)
- **Expérience :** 5 à 10 ans (palier 3)
- **Formation :** Licence (valeur 5)
- **Disponibilité :** 15 jours (palier 1)
- **Localisation :** Douala
- **Salaire souhaité :** 450 000 — 550 000 FCFA

-----

### Couche 1 — Critères bloquants

|Critère        |Résultat                                      |
|---------------|----------------------------------------------|
|Bilingue FR+EN |✅ PASS                                        |
|Minimum Licence|✅ PASS (Licence = valeur 5 ≥ valeur Licence 5)|

→ **On continue vers le score principal**

-----

### Couche 2 — Calcul bloc par bloc

#### Bloc Compétences (poids 35%, λ = 0.8)

|Compétence|Requis|Candidat|Écart|Score         |Poids|
|----------|------|--------|-----|--------------|-----|
|Laravel   |5     |4       |1    |e^(-0.8) = 45%|5    |
|PHP       |4     |4       |0    |100%          |4    |
|MySQL     |3     |2       |1    |e^(-0.8) = 45%|3    |
|Git       |2     |3       |0    |100%          |2    |

```
Score = (45×5 + 100×4 + 45×3 + 100×2) / 14 = 960/14 = 68.6%
```

#### Bloc Expérience (poids 35%, λ = 0.8)

```
Requis : palier 2 | Candidat : palier 3 (dépasse) → écart = 0
Score = e^(-0.8×0) = 100%
```

#### Bloc Formation (poids 15%, λ = 0.8)

```
Requis : Master (6) | Candidat : Licence (5) → écart = 1
Score = e^(-0.8×1) = 45%
```

#### Bloc Disponibilité (poids 4%, λ = 0.2)

```
Requis : 30 jours (palier 2) | Candidat : 15 jours (palier 1) → disponible plus tôt → écart = 0
Score = 100%
```

#### Bloc Localisation (poids 3%, λ = 0.2)

```
Offre : Douala | Candidat : Douala → même ville → écart = 0
Score = 100%
```

#### Bloc Salaire (poids 8%, λ = 0.3)

```
Chevauchement = min(600k, 550k) - max(400k, 450k) = 550 000 - 450 000 = +100 000
Chevauchement positif → Score = 100%
```

-----

### Agrégation

```
Score = (68.6% × 35%) + (100% × 35%) + (45% × 15%)
      + (100% × 8%)  + (100% × 4%)  + (100% × 3%)

Score = 24.01 + 35.00 + 6.75 + 8.00 + 4.00 + 3.00

Score Principal = 80.76%
```

-----

### Couche 3 — Atouts

```
Atouts recherchés : 3/5
→ Expérience secteur Télécoms   ✓
→ Certification AWS             ✗
→ Expérience télétravail        ✓
→ Anglais professionnel         ✓
→ Expérience en PME             ✗

Compétences supplémentaires : 2
→ Vue.js
→ Docker
```

-----

### Résultat final

```
┌─────────────────────────────────────────────────┐
│  Compatibilité                      80.76%       │
├─────────────────────────────────────────────────┤
│  Compétences                        68.6%  ⚠️    │
│  Expérience                        100.0%  ✅    │
│  Formation                          45.0%  ⚠️    │
│  Disponibilité                     100.0%  ✅    │
│  Localisation                      100.0%  ✅    │
│  Salaire                           100.0%  ✅    │
├─────────────────────────────────────────────────┤
│  Atouts recherchés                   3/5         │
│  Compétences supplémentaires          2          │
└─────────────────────────────────────────────────┘
```

**Lecture du résultat :** Jean est un candidat solide à 80.76%. Ses deux points faibles sont identifiables immédiatement — formation en dessous du Master requis, et niveau Laravel légèrement insuffisant sur la compétence principale. Son expérience et sa disponibilité sont parfaites. Le recruteur peut décider en connaissance de cause.

-----

*MatchRH — Document confidentiel — Usage interne — Juin 2026*