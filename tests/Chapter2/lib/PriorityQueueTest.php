<?php

use PHPUnit\Framework\TestCase;

final class PriorityQueueTest extends TestCase {
  /**
  * @covers PriorityQueue::__get
  */
  public function testGet() {
    $pq = new PriorityQueue();
    $this->assertTrue($pq->empty);
  }

  /**
  * @covers PriorityQueue::__get
  */
  public function testGetUnknownProperty() {
    $pq = new PriorityQueue();
    $this->assertNull($pq->unknownProperty);
  }

  /**
  * @covers PriorityQueue::push
  */
  public function testPush() {
    $pq = new PriorityQueue();
    $node = new Node('A', NULL, 1, 2);
    $pq->push($node);
    $this->assertSame($node, $pq->pop());
  }

  /**
  * @covers PriorityQueue::pop
  */
  public function testPop() {
    $pq = new PriorityQueue();
    $node = new Node('A', NULL, 1, 2);
    $pq->push($node);
    $this->assertSame($node, $pq->pop());
  }

  /**
  * @covers PriorityQueue::getPriority
  */
  public function testGetPriority() {
    $pq = new PriorityQueue_TestProxy();
    $node = new Node('A', NULL, 1, 2);
    $this->assertEquals(-3, $pq->getPriority($node));
  }
}

class PriorityQueue_TestProxy extends PriorityQueue {
  public function getPriority(Node $node): float {
    return parent::getPriority($node);
  }
}
