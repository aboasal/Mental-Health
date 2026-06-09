<?php
// modules/wellness_repository/MoodEntry.php

class MoodEntry
{
    private int $patientId;
    private DateTime $date;
    private int $moodScore; // 1 (Very Low) to 10 (Excellent)
    private array $tags; // e.g., ['stressed', 'slept poorly', 'exercised']

    public function __construct(int $patientId, string $dateString, int $moodScore, array $tags = [])
    {
        $this->patientId = $patientId;
        $this->date = new DateTime($dateString);
        $this->moodScore = $moodScore;
        $this->tags = $tags;
    }

    public function getScore(): int
    {
        return $this->moodScore;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
}
