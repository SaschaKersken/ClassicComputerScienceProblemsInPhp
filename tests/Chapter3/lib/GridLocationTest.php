<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class GridLocationTest extends TestCase {
  /**
  * @covers GridLocation::__construct
  */
  public function testConstruct() {
    $gridLocation = new GridLocation(0, 0);
    $this->assertInstanceOf('GridLocation', $gridLocation);
  }
}
