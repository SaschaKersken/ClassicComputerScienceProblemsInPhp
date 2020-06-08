<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class NucleotideTest extends TestCase {
  /**
  * @covers Nucleotide::__construct
  */
  public function testConstruct() {
    $nucleotide = new Nucleotide('A');
    $this->assertInstanceOf('Nucleotide', $nucleotide);
  }

  /**
  * @covers Nucleotide::__construct
  */
  public function testConstructExpectingException() {
    try {
      $nucleotide = new Nucleotide('X');
      $this->fail('Expected InvalidArgumentException not thrown.');
    } catch (InvalidArgumentException $e) {
      $this->assertEquals(
        "Nucleotide must be 'A', 'C', 'G', or 'T'.",
        $e->getMessage()
      );
    }
  }

  /**
  * @covers Nucleotide::__toString
  */
  public function testToString() {
    $nucleotide = new Nucleotide('A');
    $this->assertEquals('A', $nucleotide->__toString());
  }
}
