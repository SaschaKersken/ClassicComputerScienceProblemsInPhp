<?php

require_once(__DIR__.'/../../Util.php');

use PHPUnit\Framework\TestCase;

final class MCStateTest extends TestCase {
  /**
  * @covers MCState::__construct
  */
  public function testConstruct() {
    $mc = new MCState(3, 3, TRUE);
    $this->assertInstanceOf('MCState', $mc);
  }

  /**
  * @covers MCState::__toString
  */
  public function testToString() {
    $expected = "There are 3 missionaries and 3 cannibals on the west bank.
There are 0 missionaries and 0 cannibals on the east bank.
The boat is on the west bank.";
    $mc = new MCState(3, 3, TRUE);
    $this->assertSame($expected, $mc->__toString());
  }
}
