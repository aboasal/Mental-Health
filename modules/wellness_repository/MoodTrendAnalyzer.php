<?php
// modules/wellness_repository/MoodTrendAnalyzer.php

class MoodTrendAnalyzer
{

    /**
     * Calculates the average mood score over a 7-day period.
     */
    public function calculateWeeklyAverage(array $moodEntries): float
    {
        if (empty($moodEntries)) {
            return 0.0;
        }

        $totalScore = 0;
        foreach ($moodEntries as $entry) {
            $totalScore += $entry->getScore();
        }

        return round($totalScore / count($moodEntries), 2);
    }

    /**
     * Identifies which tags (e.g., 'stressed', 'insomnia') appear most frequently 
     * on days where the mood score is below a certain threshold (e.g., < 5).
     */
    public function identifyNegativeTriggers(array $moodEntries, int $lowMoodThreshold = 5): array
    {
        $triggerCounts = [];

        foreach ($moodEntries as $entry) {
            if ($entry->getScore() < $lowMoodThreshold) {
                foreach ($entry->getTags() as $tag) {
                    if (!isset($triggerCounts[$tag])) {
                        $triggerCounts[$tag] = 0;
                    }
                    $triggerCounts[$tag]++;
                }
            }
        }

        // Sort descending so the most frequent triggers are at the top
        arsort($triggerCounts);
        return $triggerCounts;
    }

    /**
     * Prepares the data array needed to render a JavaScript chart (like Chart.js) on the frontend.
     */
    public function generateChartData(array $moodEntries): array
    {
        $labels = [];
        $data = [];

        // Assuming entries are sorted by date
        foreach ($moodEntries as $entry) {
            $labels[] = $entry->getDate()->format('D, M j'); // e.g., "Mon, May 4"
            $data[] = $entry->getScore();
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Daily Mood Score',
                    'data' => $data,
                ]
            ]
        ];
    }
}
