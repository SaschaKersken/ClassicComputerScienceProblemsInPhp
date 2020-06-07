<?php

require_once(__DIR__.'/../../Util.php');

use PHPUnit\Framework\TestCase;

class DijkstraNodeTest extends TestCase {
  /**
  * @covers DijkstraNode::__construct
  */
  public function testConstruct() {
    $dn = new DijkstraNode(0, 0);
    $this->assertInstanceOf('DijkstraNode', $dn);
  }
}
