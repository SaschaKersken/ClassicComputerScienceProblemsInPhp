<?php

require_once(__DIR__.'/../../../Util.php');

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
  * @covers Graph::addEdgeByIndices {
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

  /**
  * @covers Graph::addEdgeByVertices
  */
  public function testAddEdgeByVerticesExpectingException() {
    $graph = new Graph(['V1', 'V2']);
    try {
      $graph->addEdgeByVertices('V2', 'V3');
      $this->fail('Expected InvalidArgumentException not thrown.');
    } catch(InvalidArgumentException $e) {
      $this->assertEquals(
        'Trying to add edge for vertices that are not part of the current graph.',
         $e->getMessage()
      );
    }
  }

  /**
  * @covers Graph::vertexAt
  */
  public function testVertexAt() {
    $graph = new Graph(['V1', 'V2']);
    $this->assertEquals('V1', $graph->vertexAt(0));
  }

  /**
  * @covers Graph::indexOf
  */
  public function testIndexOf() {
    $graph = new Graph(['V1', 'V2']);
    $this->assertEquals(0, $graph->indexOf('V1'));
  }

  /**
  * @covers Graph::neighborsForIndex
  */
  public function testNeighborsForIndex() {
    $graph = new Graph(['V1', 'V2', 'V3']);
    $graph->addEdgeByVertices('V1', 'V2');
    $graph->addEdgeByVertices('V2', 'V3');
    $this->assertEquals(['V1', 'V3'], $graph->neighborsForIndex(1));
  }

  /**
  * @covers Graph::neighborsForVertex
  */
  public function testNeighborsForVertex() {
    $graph = new Graph(['V1', 'V2', 'V3']);
    $graph->addEdgeByVertices('V1', 'V2');
    $graph->addEdgeByVertices('V2', 'V3');
    $this->assertEquals(['V1', 'V3'], $graph->neighborsForVertex('V2'));
  }

  /**
  * @covers Graph::edgesForIndex
  */
  public function testEdgesForIndex() {
    $graph = new Graph(['V1', 'V2', 'V3']);
    $graph->addEdgeByIndices(0, 1);
    $graph->addEdgeByIndices(1, 2);
    $this->assertEquals(
      [new Edge(1, 0), new Edge(1, 2)],
      $graph->edgesForIndex(1)
    );
  }

  /**
  * @covers Graph::edgesForVertex
  */
  public function testEdgesForVertex() {
    $graph = new Graph(['V1', 'V2', 'V3']);
    $graph->addEdgeByIndices(0, 1);
    $graph->addEdgeByIndices(1, 2);
    $this->assertEquals(
      [new Edge(1, 0), new Edge(1, 2)],
      $graph->edgesForVertex('V2')
    );
  }

  /**
  * @covers Graph::__toString
  */
  public function testToString() {
    $graph = new Graph(['V1', 'V2', 'V3']);
    $graph->addEdgeByVertices('V1', 'V2');
    $graph->addEdgeByVertices('V2', 'V3');
    $this->assertEquals(
      "V1 -> V2\nV2 -> V1, V3\nV3 -> V2\n",
      $graph->__toString()
    );
  }
}
