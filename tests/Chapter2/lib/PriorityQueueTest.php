<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class PriorityQueueTest extends TestCase {
  /**
  * @covers PriorityQueue::push
  */
  public function testPushWithNodes() {
    $node1 = new Node(NULL, NULL, 2.0, 2.0);
    $node2 = new Node(NULL, NULL, 1.0, 1.0);
    $node3 = new Node(NULL, NULL, 3.0, 3.0);
    $pq = new PriorityQueue();
    $pq->push($node1);
    $pq->push($node2);
    $pq->push($node3);
    $this->assertSame($node2, $pq->pop());
  }

  /**
  * @covers PriorityQueue::push
  */
  public function testPushWithNumbers() {
    $pq = new PriorityQueue();
    $pq->push(2);
    $pq->push(1);
    $pq->push(3);
    $this->assertEquals(1, $pq->pop());
  }

  /**
  * @covers PriorityQueue::pop
  */
  public function testPopWithNodes() {
    $node1 = new Node(NULL, NULL, 2.0, 2.0);
    $node2 = new Node(NULL, NULL, 1.0, 1.0);
    $node3 = new Node(NULL, NULL, 3.0, 3.0);
    $pq = new PriorityQueue();
    $pq->push($node1);
    $pq->push($node2);
    $pq->push($node3);
    $this->assertSame($node2, $pq->pop());
  }

  /**
  * @covers PriorityQueue::pop
  */
  public function testPopWithNumbers() {
    $pq = new PriorityQueue();
    $pq->push(42);
    $pq->push(23);
    $this->assertEquals(23, $pq->pop());
  }
}
