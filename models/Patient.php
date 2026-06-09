<?php
// models/Patient.php
require_once 'User.php';

class Patient extends User
{
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
}
