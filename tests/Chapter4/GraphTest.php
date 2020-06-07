<?php

require_once(__DIR__.'/../../Util.php');

use PHPUnit\Framework\TestCase;

final class GraphTest extends TestCase {
  /**
  * @covers Graph::__construct
  */
  public function testConstruct() {
    $graph = new Graph(['V1', 'V2']);
    $this->assertInstanceOf('Graph', $graph);
  }

  /**
  * @covers Graph::__get
  * @dataProvider getProvider
  */
  public function testGet($property, $expected) {
    $graph = new Graph(['V1', 'V2']);
    $this->assertEquals($expected, $graph->$property);
  }

  public function getProvider() {
    return [
      ['vertexCount', 2],
      ['edgeCount', 0]
    ];
  }

  /**
  * @covers Graph::addVertex
  */
  public function testAddVertex() {
    $graph = new Graph(['V1', 'V2']);
    $this->assertEquals(2, $graph->addVertex('V3'));
  }

  /**
  * @covers Graph::addEdge
  */
  public function testAddEdge() {
    $graph = new Graph(['V1', 'V2']);
    $graph->addEdge(new Edge(0, 1));
    $this->assertEquals(2, $graph->edgeCount);
  }

  /**
  * @covers Graph::addEdgeByIndices() {
  */
  public function testAddEdgeByIndices() {
    $graph = new Graph(['V1', 'V2']);
    $graph->addEdgeByIndices(0, 1);
    $this->assertEquals(2, $graph->edgeCount);
  }

  /**
  * @covers Graph::addEdgeByVertices
  */
  public function testAddEdgeByVertices() {
    $graph = new Graph(['V1', 'V2']);
    $graph->addEdgeByVertices('V1', 'V2');
    $this->assertEquals(2, $graph->edgeCount);
  }
}
