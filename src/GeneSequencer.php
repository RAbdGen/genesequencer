<?php

namespace Dna;

class GeneSequencer
{

    public function __construct()
    {
    }

    public function countDistance(DnaSequence $seq1, DnaSequence $seq2): int {
        if (strlen($seq1->getSequence()) !== strlen($seq2->getSequence())) {
            throw new NotComparableDnaSequenceException();
        }

        $distance = 0;
        $sequence1 = $seq1->getSequence();
        $sequence2 = $seq2->getSequence();

        for ($i = 0; $i < strlen($sequence1); $i++) {
            if ($sequence1[$i] !== $sequence2[$i]) {
                $distance++;
            }
        }

        return $distance;
    }
}