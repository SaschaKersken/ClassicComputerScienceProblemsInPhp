<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class DataPointTest extends TestCase {
  /**
  * @covers DataPoint::__construct
  */
  public function testConstruct() {
    $dp = new DataPoint([10, 100]);
    $this->assertInstanceOf('DataPoint', $dp);
  }

  /**
  * @covers DataPoint::__get
  */
  public function testGet() {
    $dp = new DataPoint([10, 100]);
    $this->assertEquals(2, $dp->numDimensions);
  }

  /**
  * @covers DataPoint::__get
  */
  public function testGetUnknownProperty() {
    $dp = new DataPoint([10, 100]);
    $this->assertNull($dp->unknownProperty);
  }

  /**
  * @covers DataPoint::distance
  */
  public function testDistance() {
    $dp1 = new DataPoint([2, 2]);
    $dp2 = new DataPoint([5, 2]);
    $this->assertEquals(3, $dp1->distance($dp2));
  }

  /**
  * @covers DataPoint::__toString
  */
  public function testToString() {
    $dp = new DataPoint([23, 42]);
    $this->assertEquals('23, 42', $dp->__toString());
  }
}
