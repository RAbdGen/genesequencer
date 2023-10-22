<?php

require "vendor/autoload.php";

use Dna\DnaSequence;
use Dna\GeneSequencer;

$dnaSequence1 = new DnaSequence($argv[1]);
$dnaSequence2 = new DnaSequence($argv[2]);

$geneSequencer = new GeneSequencer();
printf("Distance : %d\n", $geneSequencer->countDistance($dnaSequence1, $dnaSequence2));