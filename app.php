<?php
require "vendor/autoload.php";
use Dna\DnaSequence;
use Dna\GeneSequencer;
use Dna\History;
use Dna\InvalidDnaSequenceException;
use Dna\NotComparableDnaSequenceException;

if ($argc < 3) {
    echo "Usage: php app.php <dna1> <dna2>\n";
    exit(1);
}

$dna1 = $argv[1];
$dna2 = $argv[2];

try {
    $dnaSequence1 = new DnaSequence($dna1);
    $dnaSequence2 = new DnaSequence($dna2);

    $geneSequencer = new GeneSequencer();
    $distance = $geneSequencer->countDistance($dnaSequence1, $dnaSequence2);

    // Enregistrement dans l'historique
    $history = new History();
    $history->record($dna1, $dna2, $distance);

    printf("Distance : %d\n", $distance);

    // Affichage des statistiques du jour
    $today = new DateTime();
    $analysesCount = $history->stats($today);
    echo sprintf("%d analyse(s) effectuée(s) aujourd'hui.\n", $analysesCount);

} catch (InvalidDnaSequenceException $e) {
    echo "Exception de type InvalidDnaSequenceException : " . $e->getMessage() . "\n";
} catch (NotComparableDnaSequenceException $e) {
    echo "Exception de type NotComparableDnaSequence : " . $e->getMessage() . "\n";
}
