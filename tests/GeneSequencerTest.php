<?php

use Dna\DnaSequence;
use Dna\GeneSequencer;
use Dna\InvalidDnaSequenceException;
use Dna\NotComparableDnaSequenceException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class GeneSequencerTest extends TestCase {

    private GeneSequencer $sequencer;

    protected function setUp(): void {
        // Initialisation commune de l'objet GeneSequencer
        $this->sequencer = new GeneSequencer();
    }

    #[DataProvider('dnaSequencesProvider')] #[Test]
    public function should_return_correct_distance(string $seq1, string $seq2, int $expectedDistance): void {
        $dna1 = new DnaSequence($seq1);
        $dna2 = new DnaSequence($seq2);
        $this->assertEquals($expectedDistance, $this->sequencer->countDistance($dna1, $dna2));
    }

    #[Test]
    public function should_return_error_for_different_length() {
        $dna1 = new DnaSequence('ATTG');
        $dna2 = new DnaSequence('ATTGC');
        $this->expectException(NotComparableDnaSequenceException::class);
        $this->sequencer->countDistance($dna1, $dna2);
    }

    #[Test]
    public function should_return_error_for_invalid_dna() {
        $this->expectException(InvalidDnaSequenceException::class);
        $this->expectExceptionMessage("La séquence ADN contient des caractères invalides.");
        new DnaSequence('ATTZ');
    }

    public static function dnaSequencesProvider(): array {
        return [
            ['ATTGCACAAGT', 'TTTGCACCAGT', 2],  // Distance 2
            ['GACCTTAGCGGTT', 'GATTCCAGAGATT', 6],  // Distance 6
            ['ATTG', 'ATTG', 0],  // Distance 0
            ['AAAT', 'CAAT', 1],  // Distance 1
        ];
    }
}
