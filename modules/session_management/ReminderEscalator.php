<?php
// modules/session_management/ReminderEscalator.php

// 1. The Observer Interface
interface ReminderObserver
{
    public function sendReminder(int $patientId, string $timeRemaining): void;
}

// 2. Concrete Observer (e.g., Email Notification Service)
class EmailReminder implements ReminderObserver
{
    public function sendReminder(int $patientId, string $timeRemaining): void
    {
        // Look up patient email in MySQL and send the notification
        error_log("Email sent to Patient ID $patientId: Your session starts in $timeRemaining.");
    }
}

// 3. The Subject (The Escalator)
class SessionReminderEscalator
{
    private array $observers = [];

    public function attach(ReminderObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    /**
     * Evaluates the time until the session and triggers the necessary alerts.
     */
    public function checkAndTrigger(int $patientId, int $minutesUntilSession): void
    {
        $timeLabel = "";

        if ($minutesUntilSession === 1440) { // 24 hours
            $timeLabel = "24h";
        } elseif ($minutesUntilSession === 60) { // 1 hour
            $timeLabel = "1h";
        } elseif ($minutesUntilSession === 10) { // 10 minutes
            $timeLabel = "10m";
        }

        if ($timeLabel !== "") {
            $this->notifyObservers($patientId, $timeLabel);
        }
    }

    private function notifyObservers(int $patientId, string $timeLabel): void
    {
        foreach ($this->observers as $observer) {
            $observer->sendReminder($patientId, $timeLabel);
        }
    }
}
