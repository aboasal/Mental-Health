<?php
// modules/community_crisis/PseudonymManager.php

class PseudonymManager
{
    private PDO $dbConnection;

    private array $adjectives = ['Brave', 'Calm', 'Resilient', 'Mindful', 'Gentle', 'Strong', 'Quiet'];
    private array $nouns = ['Oak', 'River', 'Falcon', 'Breeze', 'Mountain', 'Dawn', 'Harbor'];

    public function __construct(PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * Generates a unique pseudonym and assigns it to the patient.
     */
    public function generateAndAssign(int $patientId): string
    {
        $isUnique = false;
        $pseudonym = '';

        // Keep generating until we find one that isn't taken
        while (!$isUnique) {
            $adj = $this->adjectives[array_rand($this->adjectives)];
            $noun = $this->nouns[array_rand($this->nouns)];
            $randomNumber = rand(100, 999);

            $pseudonym = $adj . $noun . $randomNumber;
            $isUnique = $this->checkUniqueness($pseudonym);
        }

        $this->saveToDatabase($patientId, $pseudonym);
        return $pseudonym;
    }

    private function checkUniqueness(string $pseudonym): bool
    {
        $stmt = $this->dbConnection->prepare("SELECT COUNT(*) FROM forum_profiles WHERE pseudonym = :pseudo");
        $stmt->execute([':pseudo' => $pseudonym]);
        return $stmt->fetchColumn() == 0;
    }

    private function saveToDatabase(int $patientId, string $pseudonym): void
    {
        $stmt = $this->dbConnection->prepare("
            INSERT INTO forum_profiles (patient_id, pseudonym) 
            VALUES (:id, :pseudo)
            ON DUPLICATE KEY UPDATE pseudonym = :pseudo
        ");
        $stmt->execute([':id' => $patientId, ':pseudo' => $pseudonym]);
    }
}
