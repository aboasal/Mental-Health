<?php
// models/Therapist.php
require_once 'User.php';

class Therapist extends User
{
    private array $specializations = [];
    private string $gender;
    private array $languages = [];
    private bool $acceptingNewMatches;

    public function __construct(string $fullName, string $email, string $gender)
    {
        parent::__construct($fullName, $email, 'Therapist');
        $this->gender = $gender;
        $this->acceptingNewMatches = true;
    }

    public function addSpecialization(string $specialization): void
    {
        $this->specializations[] = $specialization;
    }

    public function toggleAvailability(): void
    {
        // Therapist Availability "Snooze" Logic[cite: 1]
        $this->acceptingNewMatches = !$this->acceptingNewMatches;
    }
}
