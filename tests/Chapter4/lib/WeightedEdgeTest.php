<?php

use PHPUnit\Framework\TestCase;

final class WeightedEdgeTest extends TestCase {
  /**
  * @covers WeightedEdge::__construct
  */
  public function testConstruct() {
    $edge = new WeightedEdge(0, 1, 0.5);
    $this->assertInstanceOf('WeightedEdge', $edge);
  }

  /**
  * @covers WeightedEdge::reversed
  */
  public function testReversed() {
    $edge = new WeightedEdge(0, 1, 0.5);
    $this->assertEquals(new WeightedEdge(1, 0, 0.5), $edge->reversed());
  }

  /**
  * @covers WeightedEdge::__toString
  */
  public function testToString() {
    $edge = new WeightedEdge(0, 1, 0.5);
    $this->assertEquals('0 (0.50)> 1', $edge->__toString());
  }
}
