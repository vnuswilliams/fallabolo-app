# Algorithme MatchRH — Documentation Officielle

> Document de référence — Architecture et décisions de conception  
> Dernière mise à jour : Juin 2026

-----

## 1. Positionnement de l’outil

MatchRH est un **outil d’aide à la décision**, jamais un outil de sélection finale. Il améliore et accélère le processus de recrutement. L’entretien reste l’étape de validation humaine indispensable. Le CV peut être demandé par le recruteur à tout moment du processus.

> ⚠️ Tout ce qui est enregistré sur la plateforme est **déclaratif**. La responsabilité de la vérification appartient au recruteur via l’entretien.

-----

## 2. Philosophie du score

Le score n’est **jamais une valeur absolue du candidat**. Il mesure uniquement la compatibilité entre un profil candidat et une offre précise.

Un même candidat peut obtenir :

- `91%` pour une offre donnée
- `54%` pour une autre offre du même secteur

**Le score n’existe que dans la relation `candidat ↔ offre`.**

-----

## 3. Architecture — Les trois couches de l’algorithme

```
┌─────────────────────────────────────────────┐
│         COUCHE 1 — Critères bloquants        │
│         Vérification éliminatoire            │
│         Échec → Score = 0 → Fin              │
└────────────────────┬────────────────────────┘
                     │ Succès
                     ▼
┌─────────────────────────────────────────────┐
│      COUCHE 2 — Score principal pondéré      │
│      Calculé sur 100 points maximum          │
│      Pondérations fixes par template         │
└────────────────────┬────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────┐
│         COUCHE 3 — Bonus / Atouts            │
│         Points de départage                  │
│         Affichage séparé — Plafond 100%      │
└─────────────────────────────────────────────┘
```

-----

### Couche 1 — Critères bloquants

- Vérifiés **en premier**, avant tout calcul de score
- Si un seul critère bloquant échoue → `score = 0`, candidature rejetée, processus terminé
- Définis par le recruteur à la création de l’offre depuis une **bibliothèque de critères structurés**
- Le recruteur dispose d’une **liberté totale** sur ce qu’il déclare bloquant
- La plateforme affiche un **avertissement contextuel** si un critère semble incohérent avec le template choisi — mais ne bloque jamais la configuration

-----

### Couche 2 — Score principal pondéré

- Score calculé sur **100 points maximum**
- Pondérations **fixes**, non modifiables par le recruteur
- Les pondérations varient selon le **template de poste** choisi à la création de l’offre
- Chaque bloc applique une logique de **pénalité graduelle** en cas d’écart entre le profil candidat et les exigences de l’offre

-----

### Couche 3 — Bonus / Atouts

- Points supplémentaires définis **librement** par le recruteur
- Ne font **pas** partie des 100 points de base
- Score **plafonné à 100%** — les bonus ne gonflent pas au-delà
- Rôle des bonus : **départage** entre candidats à score égal + signal de valorisation affiché séparément
- Ne sont pas des compétences métier — ce sont des atouts contextuels, sectoriels ou situationnels

**Exemples d’atouts valides :**

- Expérience dans un secteur précis (BTP, banque, santé, télécoms)
- Expérience en PME ou en multinationale
- Certification spécifique (Sage Paie, PMP, CFA, etc.)
- Expérience en télétravail
- Langue supplémentaire non bloquante
- Double compétence inattendue

-----

## 4. La langue — Critère bloquant enrichi

> La langue n’est **pas intégrée** dans le score principal. Elle est gérée exclusivement comme critère bloquant.

Le recruteur choisit parmi trois modalités à la création de l’offre :

|Modalité   |Signification                   |
|-----------|--------------------------------|
|Francophone|Maîtrise du français suffisante |
|Anglophone |Maîtrise de l’anglais suffisante|
|Bilingue   |Les deux obligatoirement        |


> 🇨🇲 **Valeur par défaut : Bilingue** — cohérent avec le contexte camerounais bilingue français/anglais.

-----

## 5. Les 5 templates de poste

Le recruteur choisit son template au **début de la création de l’offre**. Ce choix détermine automatiquement les pondérations appliquées au calcul du score.

-----

### Template 1 — Manœuvres & Ouvriers

**Philosophie : Souplesse maximale**

> Les critères bloquants sont rares et très basiques. La formation n’est jamais bloquante à ce niveau. L’accent est mis sur la présence physique et la disponibilité.

|Bloc                  |Poids   |
|----------------------|--------|
|Compétences           |30%     |
|Expérience            |25%     |
|Disponibilité         |20%     |
|Localisation          |15%     |
|Formation             |5%      |
|Prétentions salariales|5%      |
|**Total**             |**100%**|

-----

### Template 2 — Employés & Techniciens

**Philosophie : Souplesse modérée**

> Les compétences techniques prennent le premier plan. Un autodidacte avec de l’expérience peut compenser un niveau de formation inférieur.

|Bloc                  |Poids   |
|----------------------|--------|
|Compétences           |45%     |
|Expérience            |25%     |
|Formation             |10%     |
|Disponibilité         |10%     |
|Localisation          |5%      |
|Prétentions salariales|5%      |
|**Total**             |**100%**|

-----

### Template 3 — Agents de maîtrise

**Philosophie : Équilibre**

> Profil charnière entre exécution et encadrement. L’expérience commence à peser autant que les compétences. La formation devient un signal de légitimité.

|Bloc                  |Poids   |
|----------------------|--------|
|Compétences           |40%     |
|Expérience            |30%     |
|Formation             |10%     |
|Disponibilité         |8%      |
|Localisation          |7%      |
|Prétentions salariales|5%      |
|**Total**             |**100%**|

-----

### Template 4 — Cadres

**Philosophie : Rigueur**

> L’expérience et les compétences se partagent le premier plan à égalité. La formation valide la légitimité académique. Le salaire devient un critère de filtrage sérieux.

|Bloc                  |Poids   |
|----------------------|--------|
|Compétences           |35%     |
|Expérience            |35%     |
|Formation             |15%     |
|Prétentions salariales|8%      |
|Disponibilité         |4%      |
|Localisation          |3%      |
|**Total**             |**100%**|

-----

### Template 5 — Cadres dirigeants & Dirigeants

**Philosophie : Exigence maximale**

> L’expérience domine tout. Les compétences sont présupposées. La formation et le salaire sont des signaux forts de positionnement et de crédibilité.

|Bloc                  |Poids   |
|----------------------|--------|
|Expérience            |45%     |
|Compétences           |25%     |
|Formation             |15%     |
|Prétentions salariales|10%     |
|Disponibilité         |3%      |
|Localisation          |2%      |
|**Total**             |**100%**|

-----

## 6. Règles de calcul par bloc

### 6.1 Bloc Compétences

- Échelle de notation : **1 à 5** pour chaque compétence (candidat et offre)
- Toutes les compétences d’une offre ont le **même poids entre elles** à l’intérieur du bloc
- Le nombre de compétences est variable — leur bloc pèse **toujours le % défini par le template**
- Le score interne est normalisé puis ramené au poids du template

**Gestion des écarts :**

|Situation                       |Traitement                                  |
|--------------------------------|--------------------------------------------|
|Niveau candidat = niveau demandé|Score plein sur cette compétence            |
|Niveau candidat > niveau demandé|Score plein — pas de sur-score              |
|Niveau candidat < niveau demandé|Pénalité graduelle proportionnelle à l’écart|


> Un candidat qui dépasse le niveau demandé n’obtient pas de points supplémentaires dans le score principal. Ce sur-niveau peut être valorisé via la **couche Bonus**.

-----

### 6.2 Bloc Expérience

- Comparaison entre les **années requises** par l’offre et les **années déclarées** par le candidat
- Pénalité graduelle si le candidat est en dessous du seuil requis
- Pas de sur-score si le candidat dépasse largement les années requises

-----

### 6.3 Bloc Formation

Échelle ordinale croissante :

```
BAC → BTS / DUT → Licence → Master → Doctorat
```

- Pénalité graduelle si le niveau est inférieur au requis
- Pas de sur-score si le niveau est supérieur au requis

-----

### 6.4 Bloc Disponibilité

- Comparaison entre la **disponibilité maximale acceptée** par le recruteur et la **disponibilité déclarée** par le candidat
- Pénalité graduelle si le candidat est disponible plus tard que souhaité
- La déclaration est sous l’**entière responsabilité du candidat**

-----

### 6.5 Bloc Localisation

Logique de proximité graduée :

```
Même ville → Même région → Même pays → Mobilité nationale
```

- Pénalité graduelle selon l’éloignement par rapport à la localisation de l’offre

-----

### 6.6 Bloc Prétentions Salariales

- Le candidat déclare un **minimum** et un **maximum**
- Le recruteur déclare une **fourchette budgétaire**
- Les deux sont **optionnels**

**Logique des cas possibles :**

|Recruteur               |Candidat                 |Traitement                             |
|------------------------|-------------------------|---------------------------------------|
|A déclaré une fourchette|A déclaré ses prétentions|Matching calculé normalement           |
|N’a pas déclaré         |A déclaré                |Bloc ignoré — non pris en compte       |
|A déclaré une fourchette|N’a pas déclaré          |Candidat = Négociable → **score plein**|
|Aucun des deux          |—                        |Bloc ignoré — non pris en compte       |

**Gestion des écarts quand les deux ont déclaré :**

|Situation                                                 |Traitement                                          |
|----------------------------------------------------------|----------------------------------------------------|
|Fourchette candidat dans le budget recruteur              |Score plein                                         |
|Minimum candidat légèrement au-dessus du maximum recruteur|Pénalité graduelle                                  |
|Minimum candidat très au-dessus du budget                 |Pénalité forte                                      |
|Maximum candidat en dessous du minimum recruteur          |Score plein — le recruteur peut négocier à la hausse|

-----

## 7. Affichage du score

### Côté recruteur

Les candidats sont classés automatiquement du plus compatible au moins compatible. En cas d’égalité de score principal, le **nombre de bonus départage**.

```
Jean Dupont      — 94%  ★★★  (3 atouts détectés)
Marie Ekoto      — 94%  ★    (1 atout détecté)
Alain Mbarga     — 89%  ★★   (2 atouts détectés)
```

-----

### Côté candidat

Le candidat voit son score **avant de postuler**, avec le détail des atouts détectés sur son profil.

```
Offre : Développeur Laravel — TechCorp
Compatibilité : 87%

Atouts détectés sur votre profil : 2
  → Expérience secteur BTP          ✓
  → Certification Sage Paie         ✓
```

-----

## 8. Principes transversaux

|Principe                   |Description                                                                          |
|---------------------------|-------------------------------------------------------------------------------------|
|**Transparence**           |Chaque composante du score est visible et explicable au recruteur                    |
|**Score relatif**          |Toujours calculé par rapport à une offre précise, jamais en valeur absolue           |
|**Contrôle plateforme**    |Les pondérations sont la propriété de MatchRH — le recruteur ne peut pas les modifier|
|**Bibliothèque structurée**|Les critères proviennent d’une bibliothèque fixe — pas de champs libres              |
|**Déclaratif assumé**      |Toutes les données sont auto-déclarées — la vérification appartient au recruteur     |
|**Pas de CV obligatoire**  |Le système fonctionne entièrement sur profils structurés                             |
|**Pénalités graduelles**   |Un écart ne tue pas une candidature, il la pénalise proportionnellement              |
|**Bonus comme départage**  |Les atouts enrichissent sans distordre le score principal                            |
|**Aide à la décision**     |MatchRH facilite le recrutement — il ne le remplace pas                              |

-----

## 9. Prochaines étapes — Ce qui reste à modéliser

- [ ] Formule mathématique exacte des pénalités graduelles
- [ ] Formule de normalisation interne du bloc compétences
- [ ] Table de conversion des niveaux de formation (valeurs numériques de l’échelle ordinale)
- [ ] Table de scoring de la localisation (coefficients par niveau de proximité)
- [ ] Poids exact de chaque bonus pour le calcul du départage

-----

*MatchRH — Document confidentiel — Usage interne*