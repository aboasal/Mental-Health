<?php
// modules/session_management/SessionStateMachine.php

class SessionStateMachine
{
    private int $sessionId;
    private string $currentState;

    // Defines the strict paths a session can take
    private const VALID_TRANSITIONS = [
        'Scheduled' => ['Patient Checked-In', 'Cancelled'],
        'Patient Checked-In' => ['Session Live', 'Cancelled'],
        'Session Live' => ['Completed'],
        'Completed' => ['Billed'],
        'Billed' => [],
        'Cancelled' => []
    ];

    public function __construct(int $sessionId, string $initialState = 'Scheduled')
    {
        $this->sessionId = $sessionId;
        $this->currentState = $initialState;
    }

    /**
     * Attempts to move the session to a new state.
     */
    public function transitionTo(string $newState): bool
    {
        $allowedNextStates = self::VALID_TRANSITIONS[$this->currentState] ?? [];

        if (in_array($newState, $allowedNextStates)) {
            $this->currentState = $newState;
            $this->updateDatabaseState();
            return true;
        }

        throw new Exception("Invalid state transition from {$this->currentState} to {$newState}");
    }

    public function getCurrentState(): string
    {
        return $this->currentState;
    }

    private function updateDatabaseState(): void
    {
        // Your MySQL PDO update logic goes here
        // e.g., UPDATE appointments SET status = :state WHERE id = :id
    }
}
