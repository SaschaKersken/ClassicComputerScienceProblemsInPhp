<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class StackTest extends TestCase {
  /**
  * @covers Stack::__get
  */
  public function testGet() {
    $stack = new Stack();
    $this->assertTrue($stack->empty);
  }

  /**
  * @covers Stack::push
  */
  public function testPush() {
    $stack = new Stack();
    $stack->push(42);
    $stack->push(23);
    $this->assertEquals(23, $stack->pop());
  }

  /**
  * @covers Stack::pop
  */
  public function testPop() {
    $stack = new Stack();
    $this->assertNull($stack->pop());
  }

  /**
  * @covers Stack::__toString
  */
  public function testToString() {
    $stack = new Stack();
    $stack->push(42);
    $stack->push(23);
    $this->assertEquals('42, 23', $stack->__toString());
  }
}
