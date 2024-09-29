<?php

namespace Dna;

use DateTime;
use DateTimeInterface;

class History {
    private string $filePath;

    public function __construct(string $filePath = 'history.json') {
        $this->filePath = $filePath;
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    public function record(string $dna1, string $dna2, int $distance): void {
        $data = json_decode(file_get_contents($this->filePath), true);
        $data[] = [
            'dna1' => $dna1,
            'dna2' => $dna2,
            'distance' => $distance,
            'date' => (new DateTime())->format('Y-m-d H:i:s'),
        ];
        file_put_contents($this->filePath, json_encode($data));
    }

    public function stats(DateTimeInterface $analysedAt): int {
        $data = json_decode(file_get_contents($this->filePath), true);
        $count = 0;
        $dateString = $analysedAt->format('Y-m-d');

        foreach ($data as $entry) {
            if (str_starts_with($entry['date'], $dateString)) {
                $count++;
            }
        }

        return $count;
    }
}
