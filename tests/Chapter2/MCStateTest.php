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

  /**
  * @covers MCState::isLegal
  * @dataProvider isLegalProvider
  */
  public function testIsLegal($wm, $wc, $expected) {
    $mc = new MCState($wm, $wc, TRUE);
    $this->assertEquals($expected, $mc->isLegal());
  }

  public function isLegalProvider() {
    return [
      [1, 2, FALSE],
      [2, 1, FALSE],
      [3, 3, TRUE]
    ];
  }

  /**
  * @covers MCState::__get
  * @dataProvider getProvider
  */
  public function testGet($property, $expected) {
    $mc = new MCState(3, 3, TRUE);
    $this->assertEquals($expected, $mc->$property);
  }

  public function getProvider() {
    return [
      ['wm', 3],
      ['wc', 3],
      ['em', 0],
      ['ec', 0],
      ['boat', TRUE]
    ];
  }

  /**
  * @covers MCState::goalTest
  */
  public function testGoalTest() {
    $mc = new MCState(0, 0, FALSE);
    $this->assertTrue(MCState::goalTest($mc));
  }
}
