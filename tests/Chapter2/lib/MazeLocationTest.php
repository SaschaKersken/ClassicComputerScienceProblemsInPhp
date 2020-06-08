<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class MazeLocationTest extends TestCase {
  /**
  * @covers MazeLocation::__construct
  */
  public function testConstruct() {
    $ml = new MazeLocation(1, 1);
    $this->assertInstanceOf('MazeLocation', $ml);
  }

  /**
  * @covers MazeLocation::getKey
  */
  public function testGetKey() {
    $ml = new MazeLocation(23, 42);
    $this->assertEquals('23:42', $ml->getKey());
  }
}
