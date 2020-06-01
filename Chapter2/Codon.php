<?php

require_once(__DIR__.'/../Util.php');

/**
* Representation of a codon
*
* Consists of three nucleotides
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Codon {
  /**
  * Internal store for the nucleotides
  * @var array
  */
  private $nucleotides = [];

  /**
  * Constructor
  *
  * @param mixed $data Array with all three nucleotides, string or Nucleotide first one
  * @param mixed $n2 optional, default NULL; string or Nucleotide second one
  * @param mixed $n3 optional, default NULL; string or Nucleotide third one
  */
  public function __construct($data, $n2 = null, $n3 = null) {
    if (is_array($data)) {
      // Parse $data, at most its first three elements, if it's an array
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
      // Otherwise use the individual nucleotides
      $this->nucleotides[] = $this->sanitize($data);
      $this->nucleotides[] = $this->sanitize($n2);
      $this->nucleotides[] = $this->sanitize($n3);
    }
  }

  /**
  * Check whether input is Nucleotide or string, return Nucleotide in any case
  *
  * @param mixed $n string or Nucleotide
  * @throws InvalidArgumentException from Nucleotide::__construct() if wrong value
  * @return Nucleotide
  */
  private function sanitize($n) {
    
    if (gettype($n) == 'object' && get_class($n) == 'Nucleotide') {
      return $n;
    }
    return new Nucleotide($n);
  }

  /**
  * Return the contained nucleotides
  *
  * @return array
  */
  public function getNucleotides() {
    return $this->nucleotides;
  }

  /**
  * String representation
  *
  * @return string
  */
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
