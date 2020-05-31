<?php

/**
* CompressedGene class
*
* Represents a gene in which the nucleotides are compressed as a bit string
*
* @package ClassicComputerScienceProblemsInPhp
*/
class CompressedGene {
  /**
  * The bit string representing the gene
  * @var string
  */
  private $bitString = '';

  /**
  * Constructor
  *
  * @param string $gene The gene to be compressed
  */
  public function __construct(string $gene) {
    // Bit counter to keep track of where we are in each compressed byte
    $bc = 0;
    // Length of last segment (needs to be stored because it might not be a full byte)
    $lengthLast = 0;

    for ($i = 0; $i < strlen($gene); $i++) {
      if ($bc == 0) {
        $byte = '';
      }
      $c = $gene[$i];
      // Add two-bit-sequence representing current nucleotide
      switch ($c) { 
      case 'A':
        $byte .= '00';
        break;
      case 'C':
        $byte .= '01';
        break;
      case 'G':
        $byte .= '10';
        break;
      case 'T':
        $byte .= '11';
        break;
      }
      // Increase bit counter
      $bc += 2;
      // If byte is full or if this is the last round
      if ($bc == 8 || $i == strlen($gene) - 1) {
        // ASCII-encode current byte and add it to bit string
        $this->bitString .= chr(bindec($byte));
        // Store current counter value because it might be the last one
        $lengthLast = $bc;
        // Reset bit counter
        $bc = 0;
      }
    }
    // Add length of last sequence to the bit string
    $this->bitString .= $lengthLast;
  }

  /**
  * Decompress the current gene and return it
  *
  * @return string the decompressed gene
  */
  public function decompress(): string {
    $gene = '';
    // Retrieve length of last segment from end of bit string
    $lengthLast = $this->bitString[-1];

    // - 1 to exclude stored segment length
    for ($i = 0; $i < strlen($this->bitString) - 1; $i++) {
      $char = $this->bitString[$i];
      // Recreate bits from character
      $byte = decbin(ord($char));
      // Normally left-pad the byte with zeros to 8 bits
      $padTo = 8;
      // If we're at the last item of the bit string
      if ($i == strlen($this->bitString) - 2) {
        // Only pad to the length of the last sequence
        $padTo = $lengthLast;
      }
      // Perform the actual left padding
      $byte = sprintf("%0${padTo}s", $byte);
      // Recreate the original nucleotides of the current byte and add them
      for ($j = 0; $j < strlen($byte) - 1; $j += 2) {
        $c = $byte[$j].$byte[$j + 1];
        switch($c) {
        case '00':
          $gene .= 'A';
          break;
        case '01':
          $gene .= 'C';
          break;
        case '10':
          $gene .= 'G';
          break;
        case '11':
          $gene .= 'T';
          break;
        }
      }
    }
    return $gene;
  }

  /**
  * Get the current bit string (for debugging etc.)
  *
  * @return string The current bit string
  */
  public function getBitString(): string {
    return $this->bitString;
  }
}
