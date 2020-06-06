<?php

require_once(__DIR__.'/../../Util.php');

use PHPUnit\Framework\TestCase;

final class NodeTest extends TestCase {
  /**
  * @covers Node::__construct
  */
  public function testConstruct() {
    $node = new Node(NULL);
    $this->assertInstanceOf('Node', $node);
  }

  /**
  * @covers Node::compare
  * @dataProvider compareProvider
  */
  public function testCompareLessThan($c1, $h1, $c2, $h2, $expected) {
    $node1 = new Node(NULL, NULL, $c1, $h1);
    $node2 = new Node(NULL, NULL, $c2, $h2);
    $this->assertEquals($expected, $node1->compare($node2));
  }

  public function compareProvider() {
    return [
      [1.0, 1.0, 2.0, 2.0, -1],
      [2.0, 2.0, 1.0, 1.0, 1],
      [1.0, 1.0, 1.0, 1.0, 0]
    ];
  }

  /**
  * @covers Node::__get
  * @dataProvider getProvider
  */
  public function testGet($property, $expected) {
    $node = new Node('Test', 'Parent', 1.0, 2.0);
    $this->assertEquals($expected, $node->$property);
  }

  public function getProvider() {
    return [
      ['state', 'Test'],
      ['parent', 'Parent'],
      ['cost', 1.0],
      ['heuristic', 2.0]
    ];
  }
}
