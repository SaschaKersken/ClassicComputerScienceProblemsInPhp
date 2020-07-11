<?php

use PHPUnit\Framework\TestCase;

final class PriorityQueueWETest extends TestCase {
  /**
  * @covers PriorityQueueWE::__get
  */
  public function testGet() {
    $pq = new PriorityQueueWE();
    $this->assertTrue($pq->empty);
  }

  /**
  * @covers PriorityQueueWE::__get
  */
  public function testGetUnknownProperty() {
    $pq = new PriorityQueueWE();
    $this->assertNull($pq->unknownProperty);
  }

  /**
  * @covers PriorityQueueWE::push
  */
  public function testPush() {
    $pq = new PriorityQueueWE();
    $edge = new WeightedEdge(1, 2, 1);
    $pq->push($edge);
    $this->assertSame($edge, $pq->pop());
  }

  /**
  * @covers PriorityQueueWE::pop
  */
  public function testPop() {
    $pq = new PriorityQueueWE();
    $edge1 = new WeightedEdge(1, 2, 5);
    $edge2 = new WeightedEdge(3, 3, 3);
    $edge3 = new WeightedEdge(1, 3, 4);
    $pq->push($edge1);
    $pq->push($edge2);
    $pq->push($edge3);
    $this->assertSame($edge2, $pq->pop());
  }
}
