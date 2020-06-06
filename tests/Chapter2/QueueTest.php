<?php

require_once(__DIR__.'/../../Util.php');

use PHPUnit\Framework\TestCase;

final class QueueTest extends TestCase {
  /**
  * @covers Queue::pop
  */
  public function testPop() {
    $queue = new Queue();
    $queue->push(42);
    $queue->push(23);
    $this->assertEquals(42, $queue->pop());
  }
}
