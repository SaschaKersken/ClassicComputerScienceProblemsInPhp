<?php

/**
* Nucleotide class
*
* Modelling a nucleotide
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Nucleotide {
  /**
  * Internal representation of the nucleotide
  * @var string
  */
  private $nucleotide = null;

  /**
  * Constructor
  *
  * @param string $nucleotide The nucleotide (has to be 'A', 'C', 'G', or 'T')
  * @throws InvalidArgumentException if $nucleotide has another value
  */
  public function __construct(string $nucleotide) {
    if (in_array(strtoupper($nucleotide), ['A', 'C', 'G', 'T'])) {
      $this->nucleotide = strtoupper($nucleotide);
    } else {
      throw new InvalidArgumentException("Nucleotide must be 'A', 'C', 'G', or 'T'.");
    }
  }

  /**
  * String representation
  *
  * @return string The nucleotide
  */
  public function __toString(): string {
    return $this->nucleotide;
  }
}
