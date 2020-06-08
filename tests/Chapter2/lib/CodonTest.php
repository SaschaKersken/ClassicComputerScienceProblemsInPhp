<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class CodonTest extends TestCase {
  /**
  * @covers Codon::__construct
  */
  public function testConstructWithArray() {
    $codon = new Codon(['A', 'C', 'G', 'T']);
    $this->assertInstanceOf('Codon', $codon);
  }

  /**
  * @covers Codon::__construct
  */
  public function testConstructWithScalars() {
    $codon = new Codon('A', 'C', 'G');
    $this->assertInstanceOf('Codon', $codon);
  }

  /**
  * @covers Codon::getNucleotides
  */
  public function testGetNucleotides() {
    $n1 = new Nucleotide('A');
    $n2 = new Nucleotide('C');
    $n3 = new Nucleotide('G');
    $codon = new Codon($n1, $n2, $n3);
    $this->assertEquals([$n1, $n2, $n3], $codon->getNucleotides());
  }

  /**
  * @covers Codon::__toString
  */
  public function testToString() {
    $codon = new Codon(['A', 'C', 'G', 'T']);
    $this->assertEquals('ACG', $codon->__toString());
  }
}
