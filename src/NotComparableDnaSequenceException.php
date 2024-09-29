<?php

namespace Dna;
class NotComparableDnaSequenceException extends \RuntimeException {
    public function __construct($message = "Les séquences ADN ne peuvent pas être comparées car elles n'ont pas la même longueur.") {
        parent::__construct($message);
    }
}
