<?php
// modules/intake_matching/MatchingEngine.php

class MatchingEngine
{

    /**
     * Finds the best therapist for a patient based on weighted criteria.
     */
    public function findBestTherapist(array $availableTherapists, array $patientPreferences): ?Therapist
    {
        $bestMatch = null;
        $highestScore = -1; // Start below 0 so even a 0 score can register if it's the only option

        foreach ($availableTherapists as $therapist) {

            // Skip therapists who have snoozed new matches
            if (!$therapist->isAcceptingNewMatches()) {
                continue;
            }

            // Calculate this specific therapist's score
            $score = $this->calculateMatchScore($therapist, $patientPreferences);

            // If it's the highest score so far, set them as the best match
            if ($score > $highestScore) {
                $highestScore = $score;
                $bestMatch = $therapist;
            }
        }

        return $bestMatch; // Returns a Therapist object, or null if no one is available
    }

    /**
     * Applies the weighted logic to calculate a compatibility score.
     */
    private function calculateMatchScore(Therapist $therapist, array $preferences): int
    {
        $score = 0;

        // Weight 1: Specialization (Highest Priority - 40 points)
        // e.g., Patient needs "Trauma" therapy, Therapist specializes in "Trauma"
        if (in_array($preferences['required_specialization'], $therapist->getSpecializations())) {
            $score += 40;
        }

        // Weight 2: Language (High Priority - 30 points)
        // Communication is critical for therapy
        if (in_array($preferences['preferred_language'], $therapist->getLanguages())) {
            $score += 30;
        }

        // Weight 3: Gender Preference (Medium Priority - 20 points)
        if ($preferences['preferred_gender'] === $therapist->getGender()) {
            $score += 20;
        }

        // Weight 4: Clinical Orientation (Lower Priority - 10 points)
        // e.g., CBT, Psychoanalysis, Mindfulness-based
        if ($preferences['clinical_orientation'] === $therapist->getClinicalOrientation()) {
            $score += 10;
        }

        return $score;
    }
}
