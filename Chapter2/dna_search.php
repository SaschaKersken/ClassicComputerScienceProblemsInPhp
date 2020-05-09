<?php

require_once(__dir__.'/../Output.php');

class Nucleotide {
  private $nucleotide = null;

  public function __construct(string $nucleotide) {
    if (in_array(strtoupper($nucleotide), ['A', 'C', 'G', 'T'])) {
      $this->nucleotide = strtoupper($nucleotide);
    } else {
      throw new InvalidArgumentException("Nucleotide must be 'A', 'C', 'G', or 'T'.");
    }
  }

  public function __toString() {
    return $this->nucleotide;
  }
}

class Codon {
  private $nucleotides = [];

  public function __construct($data, $n2 = null, $n3 = null) {
    if (is_array($data)) {
      $counter = 0;
      foreach ($data as $n) {
        $nucleotide = $this->sanitize($n);
        $this->nucleotides[] = $nucleotide;
        $counter++;
        if ($counter >= 3) {
          break;
        }
      }
    } else {
      $this->nucleotides[] = $this->sanitize($data);
      $this->nucleotides[] = $this->sanitize($n2);
      $this->nucleotides[] = $this->sanitize($n3);
    }
  }

  private function sanitize($n) {
    if (gettype($n) == 'object' && get_class($n) == 'Nucleotide') {
      return $n;
    }
    return new Nucleotide($n);
  }

  public function getNucleotides() {
    return $this->nucleotides;
  }

  public function __toString() {
    return implode(
      '',
      array_map(
        function($nucleotide) {
          return $nucleotide->__toString();
        },
        $this->nucleotides
      )
    );
  }
}

function stringToGene(string $s) : array {
  $gene = [];
  for ($i = 0; $i < strlen($s); $i++) {
    if ($i + 2 >= strlen($s)) {
      return $gene;
    }
    $codon = new Codon($s[$i], $s[$i + 1], $s[$i + 2]);
    $gene[] = $codon;
  }
  return $gene;
}

function linearContains(array $gene, Codon $keyCodon): bool {
  foreach ($gene as $codon) {
    if ($codon == $keyCodon) {
      return TRUE;
    }
  }
  return FALSE;
}

function binaryContains(array $gene, Codon $keyCodon): bool {
  $low = 0;
  $high = count($gene) - 1;
  while ($low <= $high) {
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
Output::out('ACG: '.(linearContains($myGene, $acg) ? 'yes' : 'no'));
Output::out('GAT: '.(linearcontains($myGene, $gat) ? 'yes' : 'no'));
sort($myGene);
Output::out('Binary contains:');
Output::out('ACG: '.(binaryContains($myGene, $acg) ? 'yes' : 'no'));
Output::out('GAT: '.(binaryContains($myGene, $gat) ? 'yes' : 'no'));
