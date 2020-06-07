<?php

require_once(__DIR__.'/../../Util.php');

use PHPUnit\Framework\TestCase;

final class EdgeTest extends TestCase {
  /**
  * @covers Edge::__construct
  */
  public function testConstruct() {
    $edge = new Edge(0, 1);
    $this->assertInstanceOf('Edge', $edge);
  }

  /**
  * @covers Edge::reversed
  */
  public function testReversed() {
    $edge = new Edge(0, 1);
    $this->assertEquals(new Edge(1, 0), $edge->reversed());
  }

  /**
  * @covers Edge::__toString
  */
  public function testToString() {
    $edge = new Edge(0, 1);
    $this->assertEquals('0 -> 1', $edge->__toString());
  }
}
