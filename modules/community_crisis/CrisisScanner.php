<?php
// modules/community_crisis/CrisisScanner.php

class CrisisScanner
{
    private PDO $dbConnection;

    // A strict list of high-risk keywords
    private array $crisisKeywords = [
        'suicide',
        'kill myself',
        'end it all',
        'hurt myself',
        'better off dead',
        'hopeless',
        'no way out'
    ];

    public function __construct(PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * Scans text for crisis keywords and triggers an emergency workflow if found.
     */
    public function scanContent(int $patientId, string $content, string $source): bool
    {
        $normalizedContent = strtolower($content);

        foreach ($this->crisisKeywords as $keyword) {
            // Using regex to match whole words and prevent false positives 
            // (e.g., 'hurt' matching inside 'yogurt')
            if (preg_match("/\b" . preg_quote($keyword, '/') . "\b/", $normalizedContent)) {
                $this->triggerEmergencyProtocol($patientId, $keyword, $source);
                return true; // Crisis detected
            }
        }

        return false; // Content is clean
    }

    /**
     * Logs the high-risk alert and alerts admins.
     */
    private function triggerEmergencyProtocol(int $patientId, string $triggeredWord, string $source): void
    {
        // 1. Log the unalterable safety audit trail
        $stmt = $this->dbConnection->prepare("
            INSERT INTO safety_audits (patient_id, triggered_word, source_module, status) 
            VALUES (:id, :word, :source, 'Requires Immediate Review')
        ");
        $stmt->execute([
            ':id' => $patientId,
            ':word' => $triggeredWord,
            ':source' => $source
        ]);

        // 2. In a live system, this would immediately ping the 'Emergency Resource Broadcaster'
        // or send an SMS directly to the Clinic Manager.
        error_log("CRISIS ALERT: Patient $patientId triggered flag with word '$triggeredWord' in $source.");
    }
}
