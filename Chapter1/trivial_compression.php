<?php

require_once(__DIR__.'/../Output.php');

class CompressedGene {
  private $bitString = '';

  public function __construct($gene) {
    $bc = 0;
    $lengthLast = 0;

    for ($i = 0; $i < strlen($gene); $i++) {
      if ($bc == 0) {
        $byte = '';
      }
      $c = $gene[$i];
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
      $bc += 2;
      if ($bc == 8 || $i == strlen($gene) - 1) {
        $this->bitString .= chr(bindec($byte));
        $lengthLast = $bc;
        $bc = 0;
      }
    }
    $this->bitString .= $lengthLast;
  }

  public function decompress(): string {
    $gene = '';
    $lengthLast = $this->bitString[-1];

    for ($i = 0; $i < strlen($this->bitString) - 1; $i++) {
      $char = $this->bitString[$i];
      $byte = decbin(ord($char));
      $padTo = 8;
      if ($i == strlen($this->bitString) - 2) {
        $padTo = $lengthLast;
      }
      $byte = sprintf("%0${padTo}s", $byte);
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

  public function getBitString(): string {
    return $this->bitString;
  }
}

$original = str_repeat('TAGGGATTAACCGTTATATATATATAGCCATGGATCGATTATATAGGGATTAACCGTTATATATATATAGCCATGGATCGATTATA', 100);
Output::out(sprintf("Original: %d", strlen($original)));
$compressed = new CompressedGene($original);
Output::out(sprintf("Compressed: %d", strlen($compressed->getBitString())));
if ($original == $compressed->decompress()) {
  echo "Identical\n";
} else {
  echo "Different!\n";
}
