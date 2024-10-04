<?php
require "vendor/autoload.php";

use Dna\GeneSequencer;

try {
    // Instanciation de GeneSequencer
    $geneSequencer = new GeneSequencer();

    // Appel à la méthode bulkDnaAnalysis et affichage du résultat
    $result = $geneSequencer->bulkDnaAnalysis();
    echo $result;

} catch (Exception $e) {
    // Gestion des exceptions génériques
    echo "Une erreur est survenue : " . $e->getMessage() . "\n";
}
