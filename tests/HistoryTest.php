<?php

use Dna\History;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class HistoryTest extends TestCase {
    private History $history;
    private string $testFilePath = 'test_history.json';

    protected function setUp(): void {
        $this->history = new History($this->testFilePath);

        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
        file_put_contents($this->testFilePath, json_encode([]));
    }


    protected function tearDown(): void {
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    #[Test]
    public function test_record_single_analysis(): void {
        $this->history->record('ATTGC', 'TTTGC', 2);
        $this->assertEquals(1, $this->history->stats(new DateTime()));
    }

    #[Test]
    public function test_record_multiple_analyses(): void {
        $this->history->record('ATTGC', 'TTTGC', 2);
        $this->history->record('GACCT', 'GATTCC', 3);
        $this->assertEquals(2, $this->history->stats(new DateTime()));
    }

    #[Test]
    public function test_no_analysis_yet(): void {
        $this->assertEquals(0, $this->history->stats(new DateTime()));
    }

    #[Test]
    public function test_analysis_on_specific_date(): void {
        $specificDate = new DateTime('2024-09-27 10:00:00');

        $this->history->record('ATTGC', 'TTTGC', 2);

        file_put_contents($this->testFilePath, json_encode([[
            'dna1' => 'ATTGC',
            'dna2' => 'TTTGC',
            'distance' => 2,
            'date' => $specificDate->format('Y-m-d H:i:s'),
        ]]));

        $this->assertEquals(1, $this->history->stats($specificDate));
    }

    #[Test]
    public function test_display_message_for_zero_analysis(): void {
        $message = $this->getStatisticsMessage(0);
        $this->assertEquals('0 analyses effectuées.', $message);
    }

    #[Test]
    public function test_display_message_for_one_analysis(): void {
        $this->history->record('ATTGC', 'TTTGC', 2);

        $message = $this->getStatisticsMessage(1);
        $this->assertEquals('1 analyse effectuée.', $message);
    }

    #[Test]
    public function test_display_message_for_two_analyses(): void {
        $this->history->record('GACCT', 'GATTCC', 3);

        $message = $this->getStatisticsMessage(2);
        $this->assertEquals('2 analyses effectuées.', $message);
    }

    private function getStatisticsMessage(int $count): string {
        return $count === 1 ? '1 analyse effectuée.' : "$count analyses effectuées.";
    }

}
