<?php

require_once(__DIR__.'/Codon.php');
require_once(__DIR__.'/../Output.php');

/**
* Create a gene out of a string of nucleotides
*
* @param string The nucleotides
* @return array The gene of codons
*/
function stringToGene(string $s) : array {
  $gene = [];
  for ($i = 0; $i < strlen($s); $i++) {
    if ($i + 2 >= strlen($s)) { // Don't run off end
      return $gene;
    }
    // Initialize codon out of three nucleotides
    $codon = new Codon($s[$i], $s[$i + 1], $s[$i + 2]);
    $gene[] = $codon; // Add codon to gene
  }
  return $gene;
}

/**
* Linear search for a codon
*
* @param array $gene The gene to search in
* @param Codon $keyCodon The codon to search for
* @return bool TRUE if found, otherwise FALSE
*/
function linearContains(array $gene, Codon $keyCodon): bool {
  foreach ($gene as $codon) {
    if ($codon == $keyCodon) {
      return TRUE;
    }
  }
  return FALSE;
}

/**
* Binary search for a codon
*
* @param array $gene The sorted gene to search in
* @param array $keyCodon The codon to search for
* @return bool TRUE if founc, otherwise FALSE
*/
function binaryContains(array $gene, Codon $keyCodon): bool {
  $low = 0;
  $high = count($gene) - 1;
  while ($low <= $high) { // While there is still a search space
    $mid = floor(($low + $high) / 2);
    if ($gene[$mid] < $keyCodon) {
      $low = $mid + 1;
    } elseif ($gene[$mid] > $keyCodon) {
      $high = $mid - 1;
    } else {
      return TRUE;
    }
  }
  return FALSE;
}

$geneStr = "ACGTGGCTCTCTAACGTACGTACGTACGGGGTTTATATATACCCTAGGACTCCCTTT";
$myGene = stringToGene($geneStr);
$acg = new Codon('A', 'C', 'G');
$gat = new Codon('G', 'A', 'T');
Output::out('Linear contains:');
Output::out('ACG: '.(linearContains($myGene, $acg) ? 'yes' : 'no')); // yes
Output::out('GAT: '.(linearcontains($myGene, $gat) ? 'yes' : 'no')); // no
sort($myGene);
Output::out('Binary contains:');
Output::out('ACG: '.(binaryContains($myGene, $acg) ? 'yes' : 'no')); // yes
Output::out('GAT: '.(binaryContains($myGene, $gat) ? 'yes' : 'no')); // no
