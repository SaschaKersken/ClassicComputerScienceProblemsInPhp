<?php

use PHPUnit\Framework\TestCase;

final class AlbumTest extends TestCase {
  /**
  * @covers Album::__construct
  */
  public function testConstruct() {
    $album = new Album("Thriller", 1982, 42.19, 9);
    $this->assertInstanceOf('Album', $album);
  }

  /**
  * @covers Album::__toString
  */
  public function testToString() {
    $album = new Album("Thriller", 1982, 42.19, 9);
    $this->assertEquals('Thriller, 1982', $album->__toString());
  }
}
