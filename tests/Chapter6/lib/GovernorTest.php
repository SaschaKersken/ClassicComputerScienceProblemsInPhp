<?php

use PHPUnit\Framework\TestCase;

class GovernorTest extends TestCase {
  /**
  * @covers Governor::__construct
  */
  public function testConstruct() {
    $governor = new Governor(-119.681564, 79, "California");
    $this->assertInstanceOf('Governor', $governor);
  }

  /**
  * @covers Governor::__toString
  */
  public function testToString() {
    $governor = new Governor(-119.681564, 79, "California");
    $this->assertEquals(
      'California: (longitude: -119.681564, age: 79)',
      $governor->__toString()
    );
  }
}
