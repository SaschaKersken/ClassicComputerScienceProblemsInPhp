<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class ClusterTest extends TestCase {
  /**
  * @covers Cluster::__construct
  */
  public function testConstruct() {
    $cluster = new Cluster([], new DataPoint([2, 3]));
    $this->assertInstanceOf('Cluster', $cluster);
  }
}
