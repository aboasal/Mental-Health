<?php
// models/Patient.php
require_once 'User.php';

class Patient extends User
{

    private string $levelOfCare;
    private array $intakeData = [];
    private string $triageState; // Registered, Screened, Matched, Active

    public function __construct(string $fullName, string $email)
    {
        parent::__construct($fullName, $email, 'Patient');
        $this->triageState = 'Registered'; // Initial state
    }

    public function setIntakeData(array $data): void
    {
        // Logic for parsing stress, anxiety, trauma history[cite: 1]
        $this->intakeData = $data;
        $this->updateTriageState('Screened');
    }

    public function updateTriageState(string $newState): void
    {
        $this->triageState = $newState;
    }
    public function calculateLevelOfCare(int $stressLevel, int $anxietyLevel, bool $hasTraumaHistory): void
    {
        // Base score out of 20 (assuming stress and anxiety are 1-10 scales)
        $severityScore = $stressLevel + $anxietyLevel;

        // Weighted logic for trauma history
        if ($hasTraumaHistory) {
            $severityScore += 5;
        }

        // Determine Level of Care based on the final score
        if ($severityScore >= 18) {
            $this->levelOfCare = 'High Risk - Crisis Intervention';
        } elseif ($severityScore >= 12) {
            $this->levelOfCare = 'Moderate - Specialized Therapy';
        } else {
            $this->levelOfCare = 'Low Risk - Standard Therapy & Self-Help';
        }

        // Update the state machine once screening is complete
        $this->updateTriageState('Screened');
    }

    public function getLevelOfCare(): string
    {
        return $this->levelOfCare;
    }
}
