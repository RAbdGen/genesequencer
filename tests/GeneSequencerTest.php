<?php

use Dna\DnaSequence;
use Dna\GeneSequencer;
use Dna\InvalidDnaSequenceException;
use Dna\NotComparableDnaSequenceException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Dna\DnaProviderStub; // Assurez-vous que le bon namespace est utilisé

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

    #[Test]
    public function should_return_empty_analysis_for_empty_array() {
        $providerStub = new DnaProviderStub([]);
        $this->sequencer->setDnaProvider($providerStub); // Assurez-vous que GeneSequencer peut utiliser un DnaProvider

        $result = $this->sequencer->bulkDnaAnalysis();
        $this->assertEquals("0 analyse(s) effectuée(s).\n", $result);
    }

    #[Test]
    public function should_return_analysis_for_single_dna_tuple() {
        $providerStub = new DnaProviderStub([
            (object)['dna1' => 'ACGT', 'dna2' => 'AGGT'],
        ]);
        $this->sequencer->setDnaProvider($providerStub);

        $result = $this->sequencer->bulkDnaAnalysis();
        $this->assertEquals("distance = 1 pour ACGT vs AGGT\n1 analyse(s) effectuée(s).\n", $result);
    }

    #[Test]
    public function should_return_analysis_for_two_dna_tuples() {
        $providerStub = new DnaProviderStub([
            (object)['dna1' => 'ACGT', 'dna2' => 'AGGT'],
            (object)['dna1' => 'AAGT', 'dna2' => 'ACGT'],
        ]);
        $this->sequencer->setDnaProvider($providerStub);

        $result = $this->sequencer->bulkDnaAnalysis();
        $this->assertEquals("distance = 1 pour ACGT vs AGGT\n" .
            "distance = 1 pour AAGT vs ACGT\n" .
            "2 analyse(s) effectuée(s).\n", $result);
    }

    #[Test]
    public function should_return_analysis_for_five_dna_tuples() {
        $providerStub = new DnaProviderStub([
            (object)['dna1' => 'ACGT', 'dna2' => 'AGGT'],
            (object)['dna1' => 'AAGT', 'dna2' => 'ACGT'],
            (object)['dna1' => 'TTAG', 'dna2' => 'GCTA'],
            (object)['dna1' => 'CCTA', 'dna2' => 'CCTA'],
            (object)['dna1' => 'GACC', 'dna2' => 'GACA'],
        ]);
        $this->sequencer->setDnaProvider($providerStub);

        $result = $this->sequencer->bulkDnaAnalysis();
        $this->assertEquals("distance = 1 pour ACGT vs AGGT\n" .
            "distance = 1 pour AAGT vs ACGT\n" .
            "distance = 4 pour TTAG vs GCTA\n" .
            "distance = 0 pour CCTA vs CCTA\n" .
            "distance = 1 pour GACC vs GACA\n" .
            "5 analyse(s) effectuée(s).\n", $result);
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
