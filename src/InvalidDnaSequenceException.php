<?php
namespace Dna;
class InvalidDnaSequenceException extends \InvalidArgumentException {
    public function __construct($message = "La séquence ADN contient des caractères invalides.") {
        parent::__construct($message);
    }
}
