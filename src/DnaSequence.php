<?php

namespace Dna;

class DnaSequence {
    private string $sequence;

    private const array VALID_NUCLEOTIDES = ['A', 'C', 'G', 'T'];
    public function __construct(string $sequence) {
        if (!$this->isValidSequence($sequence)) {
            throw new InvalidDnaSequenceException();
        }
        $this->sequence = $sequence;
    }

    public function getSequence(): string {
        return $this->sequence;
    }

    private function isValidSequence(string $sequence): bool {
        for ($i = 0; $i < strlen($sequence); $i++) {
            if (!in_array($sequence[$i], self::VALID_NUCLEOTIDES)) {
                return false;
            }
        }
        return true;
    }
}
