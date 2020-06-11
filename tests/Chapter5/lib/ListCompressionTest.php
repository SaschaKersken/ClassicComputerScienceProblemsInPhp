<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class ListCompressionTest extends TestCase {
  /**
  * @covers ListCompression::__construct
  */
  public function testConstruct() {
    $listCompression = new ListCompression([1, 2, 3]);
    $this->assertInstanceOf('ListCompression', $listCompression);
  }

  /**
  * @covers ListCompression::__get
  */
  public function testGet() {
    $listCompression = new ListCompression([1, 2, 3]);
    $this->assertIsInt($listCompression->bytesCompressed);
  }

  /**
  * @covers ListCompression::__get
  */
  public function testGetUnknownProperty() {
    $listCompression = new ListCompression([1, 2, 3]);
    $this->assertNull($listCompression->noSuchProperty);
  }

  /**
  * @covers ListCompression::fitness
  */
  public function testFitness() {
    $listCompression = new ListCompression([1, 2, 3]);
    $this->assertIsFloat($listCompression->fitness());
  }

  /**
  * @covers ListCompression::randomInstance
  */
  public function testRandomInstance() {
    $this->assertInstanceOf(
      'ListCompression',
      ListCompression::randomInstance()
    );
  }

  /**
  * @covers ListCompression::crossover
  */
  public function testCrossover() {
    $listCompression = new ListCompression([1, 2, 3]);
    $children = $listCompression->crossover(new ListCompression([4, 5, 6]));
    $this->assertEquals(2, count($children));
  }

  /**
  * @covers ListCompression::mutate
  */
  public function testMutate() {
    $listCompression = new ListCompression([1, 2, 3]);
    $listCompression->mutate();
    $this->assertIsInt($listCompression->bytesCompressed);
  }

  /**
  * @covers ListCompression::__toString
  */
  public function testToString() {
    $listCompression = new ListCompression([1, 2, 3]);
    $this->assertMatchesRegularExpression(
      '(^Order: 1, 2, 3; Bytes: \d+$)',
      $listCompression->__toString()
    );
  }
}
