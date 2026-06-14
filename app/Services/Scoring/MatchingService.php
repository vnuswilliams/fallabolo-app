<?php

namespace App\Services\Scoring;

use App\Enums\AvailabilityEnum;
use App\Enums\EducationLevelEnum;
use App\Enums\ExperienceTierEnum;
use App\Enums\JobTemplateEnum;
use App\Models\JobOffer;

class MatchingService
{
    /**
     * Configuration des templates : poids et lambdas par bloc.
     */
    protected const TEMPLATES_CONFIG = [
        JobTemplateEnum::MANOEUVRE->value => [
            'weights' => [
                'skills' => 0.30,
                'experience' => 0.25,
                'availability' => 0.20,
                'location' => 0.15,
                'education' => 0.05,
                'salary' => 0.05,
            ],
            'lambdas' => [
                'skills' => 0.2,
                'experience' => 0.2,
                'education' => 0.2,
                'availability' => 0.1,
                'location' => 0.1,
                'salary' => 0.1,
            ],
        ],
        JobTemplateEnum::TECHNICIEN->value => [
            'weights' => [
                'skills' => 0.45,
                'experience' => 0.25,
                'education' => 0.10,
                'availability' => 0.10,
                'location' => 0.05,
                'salary' => 0.05,
            ],
            'lambdas' => [
                'skills' => 0.4,
                'experience' => 0.4,
                'education' => 0.4,
                'availability' => 0.1,
                'location' => 0.1,
                'salary' => 0.1,
            ],
        ],
        JobTemplateEnum::AGENT->value => [
            'weights' => [
                'skills' => 0.40,
                'experience' => 0.30,
                'education' => 0.10,
                'availability' => 0.08,
                'location' => 0.07,
                'salary' => 0.05,
            ],
            'lambdas' => [
                'skills' => 0.6,
                'experience' => 0.6,
                'education' => 0.6,
                'availability' => 0.2,
                'location' => 0.2,
                'salary' => 0.2,
            ],
        ],
        JobTemplateEnum::CADRE->value => [
            'weights' => [
                'skills' => 0.35,
                'experience' => 0.35,
                'education' => 0.15,
                'salary' => 0.08,
                'availability' => 0.04,
                'location' => 0.03,
            ],
            'lambdas' => [
                'skills' => 0.8,
                'experience' => 0.8,
                'education' => 0.8,
                'salary' => 0.3,
                'availability' => 0.2,
                'location' => 0.2,
            ],
        ],
        JobTemplateEnum::DIRIGEANT->value => [
            'weights' => [
                'experience' => 0.45,
                'skills' => 0.25,
                'education' => 0.15,
                'salary' => 0.10,
                'availability' => 0.03,
                'location' => 0.02,
            ],
            'lambdas' => [
                'experience' => 1.0,
                'skills' => 1.0,
                'education' => 1.0,
                'salary' => 0.4,
                'availability' => 0.3,
                'location' => 0.3,
            ],
        ],
    ];

    /**
     * Calcule le score complet pour une offre et un candidat.
     */
    public function calculate(JobOffer $offer, array $candidateData): array
    {
        $template = $offer->template->value;
        $config = self::TEMPLATES_CONFIG[$template];

        // 1. Couche 1 : Critères bloquants
        if (! $this->checkBlocking($offer, $candidateData)) {
            return [
                'passed_blocking' => false,
                'score_principal' => 0,
                'scores_details' => [],
            ];
        }

        // 2. Couche 2 : Calcul des scores par bloc
        $scores = [
            'skills' => $this->calculateBlocSkills($offer, $candidateData, $config['lambdas']['skills']),
            'experience' => $this->calculateBlocExperience($offer, $candidateData, $config['lambdas']['experience']),
            'education' => $this->calculateBlocEducation($offer, $candidateData, $config['lambdas']['education']),
            'availability' => $this->calculateBlocAvailability($offer, $candidateData, $config['lambdas']['availability']),
            'location' => $this->calculateBlocLocation($offer, $candidateData, $config['lambdas']['location']),
            'salary' => $this->calculateBlocSalary($offer, $candidateData, $config['lambdas']['salary']),
        ];

        // Détermination des blocs à ignorer
        $ignoredBlocs = [];
        if (! $offer->budget_max) {
            $ignoredBlocs[] = 'salary';
        }

        // 3. Agrégation
        $finalScore = $this->aggregate($scores, $config['weights'], $ignoredBlocs);

        return [
            'passed_blocking' => true,
            'score_principal' => round($finalScore * 100, 2),
            'scores_details' => array_map(fn ($s) => round($s * 100, 2), $scores),
            'assets_matched' => $this->getMatchedAssets($offer, $candidateData),
            'extra_skills' => $this->getExtraSkills($offer, $candidateData),
        ];
    }

    /**
     * Vérifie les critères bloquants.
     */
    public function checkBlocking(JobOffer $offer, array $candidateData): bool
    {
        // Langue
        if ($offer->blocking_language && isset($candidateData['language_profile'])) {
            $candidateLang = $candidateData['language_profile'];
            if (! $candidateLang->satisfies($offer->blocking_language)) {
                return false;
            }
        }

        // Formation
        if ($offer->blocking_education && isset($candidateData['education_level'])) {
            if ($candidateData['education_level']->valueWeight() < $offer->blocking_education->valueWeight()) {
                return false;
            }
        }

        // Expérience
        if ($offer->blocking_experience && isset($candidateData['experience_tier'])) {
            if ($candidateData['experience_tier']->valueWeight() < $offer->blocking_experience->valueWeight()) {
                return false;
            }
        }

        // Disponibilité
        if ($offer->blocking_availability && isset($candidateData['availability'])) {
            if ($candidateData['availability']->valueWeight() > $offer->blocking_availability->valueWeight()) {
                return false;
            }
        }

        // Permis (si implémenté)
        // TODO: Implémenter le check du permis si nécessaire

        return true;
    }

    /**
     * Calcul du bloc Compétences.
     */
    protected function calculateBlocSkills(JobOffer $offer, array $candidateData, float $lambda): float
    {
        $requiredSkills = $offer->jobRequiredSkills;
        if ($requiredSkills->isEmpty()) {
            return 1.0;
        }

        $candidateSkills = $candidateData['skills'] ?? [];
        $totalWeightedScore = 0;
        $totalWeights = 0;

        foreach ($requiredSkills as $req) {
            $skillId = $req->skill_id;
            $levelRequired = $req->level_required;
            $candidateLevel = $candidateSkills[$skillId] ?? 0;

            $diff = max(0, $levelRequired - $candidateLevel);
            $score = exp(-$lambda * $diff);

            $totalWeightedScore += $score * $levelRequired;
            $totalWeights += $levelRequired;
        }

        return $totalWeights > 0 ? $totalWeightedScore / $totalWeights : 0;
    }

    /**
     * Calcul du bloc Expérience.
     */
    protected function calculateBlocExperience(JobOffer $offer, array $candidateData, float $lambda): float
    {
        $required = $offer->required_experience;
        if (! $required) {
            return 1.0;
        }

        $candidate = $candidateData['experience_tier'] ?? ExperienceTierEnum::TIER_0;

        $diff = max(0, $required->valueWeight() - $candidate->valueWeight());

        return exp(-$lambda * $diff);
    }

    /**
     * Calcul du bloc Formation.
     */
    protected function calculateBlocEducation(JobOffer $offer, array $candidateData, float $lambda): float
    {
        $required = $offer->required_education;
        if (! $required) {
            return 1.0;
        }

        $candidate = $candidateData['education_level'] ?? EducationLevelEnum::NONE;

        $diff = max(0, $required->valueWeight() - $candidate->valueWeight());

        return exp(-$lambda * $diff);
    }

    /**
     * Calcul du bloc Disponibilité.
     */
    protected function calculateBlocAvailability(JobOffer $offer, array $candidateData, float $lambda): float
    {
        $required = $offer->required_availability;
        if (! $required) {
            return 1.0;
        }

        $candidate = $candidateData['availability'] ?? AvailabilityEnum::MORE;

        // Ici, un palier plus élevé signifie plus d'attente, donc c'est l'inverse des autres.
        $diff = max(0, $candidate->valueWeight() - $required->valueWeight());

        return exp(-$lambda * $diff);
    }

    /**
     * Calcul du bloc Localisation.
     */
    protected function calculateBlocLocation(JobOffer $offer, array $candidateData, float $lambda): float
    {
        if (! isset($candidateData['city'])) {
            return 0.5;
        } // Valeur par défaut moyenne

        $diff = 3; // Par défaut : Pays différent ou non spécifié

        if ($candidateData['city'] === $offer->city) {
            $diff = 0;
        } elseif (($candidateData['region'] ?? '') === $offer->region) {
            $diff = 1;
        } elseif (($candidateData['country'] ?? '') === $offer->country) {
            $diff = 2;
        }

        return exp(-$lambda * $diff);
    }

    /**
     * Calcul du bloc Salaire.
     */
    protected function calculateBlocSalary(JobOffer $offer, array $candidateData, float $lambda): float
    {
        $budgetMin = $offer->budget_min;
        $budgetMax = $offer->budget_max;
        $candidateMin = $candidateData['salary_min'] ?? null;
        $candidateMax = $candidateData['salary_max'] ?? null;

        if (! $budgetMax) {
            return 1.0; // Recruteur n'a pas déclaré -> Sera ignoré via aggregate
        }

        if (! $candidateMin) {
            return 1.0; // Candidat n'a pas déclaré = Négociable -> Score 100%
        }

        // Chevauchement
        $overlap = min($budgetMax, $candidateMax ?? PHP_INT_MAX) - max($budgetMin ?? 0, $candidateMin);

        if ($overlap >= 0) {
            return 1.0;
        }

        // Si le salaire max du candidat est en dessous du min recruteur, c'est bon aussi
        if ($candidateMax && $candidateMax < $budgetMin) {
            return 1.0;
        }

        // Pénalité
        $gap = abs($overlap) / $budgetMax;

        return exp(-$lambda * $gap);
    }

    /**
     * Agrégation des scores avec redistribution des poids si nécessaire.
     */
    protected function aggregate(array $scores, array $weights, array $ignoredBlocs = []): float
    {
        $totalWeightPossible = array_sum($weights);
        $ignoredWeight = 0;
        foreach ($ignoredBlocs as $bloc) {
            $ignoredWeight += $weights[$bloc] ?? 0;
        }

        $availableWeight = $totalWeightPossible - $ignoredWeight;
        if ($availableWeight <= 0) {
            return 0;
        }

        $finalScore = 0;
        foreach ($weights as $bloc => $weight) {
            if (in_array($bloc, $ignoredBlocs)) {
                continue;
            }

            // Redistribution : le nouveau poids est weight * (totalWeightPossible / availableWeight)
            $effectiveWeight = $weight * ($totalWeightPossible / $availableWeight);
            $finalScore += ($scores[$bloc] ?? 0) * $effectiveWeight;
        }

        return $finalScore;
    }

    /**
     * Identifie les atouts qui matchent.
     */
    protected function getMatchedAssets(JobOffer $offer, array $candidateData): array
    {
        $requiredAssets = collect($offer->required_assets ?? []);
        $candidateAssets = collect($candidateData['assets'] ?? []);

        return $requiredAssets->filter(function ($asset) use ($candidateAssets) {
            return $candidateAssets->contains($asset['asset_id']);
        })->values()->all();
    }

    /**
     * Identifie les compétences supplémentaires du candidat.
     */
    protected function getExtraSkills(JobOffer $offer, array $candidateData): array
    {
        $requiredSkillIds = $offer->jobRequiredSkills->pluck('skill_id')->all();
        $candidateSkills = $candidateData['skills'] ?? [];

        $extraSkillIds = array_diff(array_keys($candidateSkills), $requiredSkillIds);

        return $extraSkillIds;
    }
}
