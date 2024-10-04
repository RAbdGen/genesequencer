<?php

namespace Dna;

use AllowDynamicProperties;
use Jfredon\FakeAnalyticsData\DnaProvider;

#[AllowDynamicProperties] class GeneSequencer
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
    public function setDnaProvider(DnaProvider $provider): void {
        $this->dnaProvider = $provider;
    }

    public function bulkDnaAnalysis(): string {
        $dnaTuples = $this->dnaProvider->generate();
        $result = "";
        $analysisCount = count($dnaTuples);

        foreach ($dnaTuples as $dnaTuple) {
            $distance = $this->countDistance(new DnaSequence($dnaTuple->dna1), new DnaSequence($dnaTuple->dna2));
            $result .= sprintf("distance = %d pour %s vs %s\n", $distance, $dnaTuple->dna1, $dnaTuple->dna2);
        }

        return $result . sprintf("%d analyse(s) effectuée(s).\n", $analysisCount);
    }
}