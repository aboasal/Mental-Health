<?php
// modules/session_management/AppointmentScheduler.php

class AppointmentScheduler
{
    private PDO $dbConnection;

    public function __construct(PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * Attempts to book a session if the time slot is free.
     */
    public function scheduleSession(int $therapistId, int $patientId, DateTime $startTimeUTC, int $durationMinutes): bool
    {
        // Calculate the end time
        $endTimeUTC = clone $startTimeUTC;
        $endTimeUTC->modify("+$durationMinutes minutes");

        if ($this->hasConflict($therapistId, $startTimeUTC, $endTimeUTC)) {
            return false; // Time slot is already taken
        }

        // Proceed to insert the new appointment into the database
        $stmt = $this->dbConnection->prepare("
            INSERT INTO appointments (therapist_id, patient_id, start_time, end_time, status) 
            VALUES (:therapist, :patient, :start, :end, 'Scheduled')
        ");

        return $stmt->execute([
            ':therapist' => $therapistId,
            ':patient' => $patientId,
            ':start' => $startTimeUTC->format('Y-m-d H:i:s'),
            ':end' => $endTimeUTC->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Checks the database for any overlapping appointments for a specific therapist.
     */
    private function hasConflict(int $therapistId, DateTime $requestedStart, DateTime $requestedEnd): bool
    {
        // A conflict occurs if an existing appointment starts before the requested end time 
        // AND ends after the requested start time.
        $stmt = $this->dbConnection->prepare("
            SELECT COUNT(*) FROM appointments 
            WHERE therapist_id = :therapist 
            AND status != 'Cancelled'
            AND start_time < :requestedEnd 
            AND end_time > :requestedStart
        ");

        $stmt->execute([
            ':therapist' => $therapistId,
            ':requestedStart' => $requestedStart->format('Y-m-d H:i:s'),
            ':requestedEnd' => $requestedEnd->format('Y-m-d H:i:s')
        ]);

        return $stmt->fetchColumn() > 0;
    }
}
