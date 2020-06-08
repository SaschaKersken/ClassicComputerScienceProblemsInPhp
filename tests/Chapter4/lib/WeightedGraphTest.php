<?php

require_once(__DIR__.'/../../../Util.php');

use \PHPUnit\Framework\TestCase;

class WeightedGraphTest extends TestCase {
  /**
  * @covers WeightedGraph::addWeightedEdgeByIndices
  */
  public function testAddWeightedEdgeByIndices() {
    $graph = new WeightedGraph(['V1', 'V2']);
    $graph->addWeightedEdgeByIndices(0, 1, 0.5);
    $this->assertEquals(
      [new WeightedEdge(0, 1, 0.5)],
      $graph->edgesForVertex('V1')
    );
  }

  /**
  * @covers WeightedGraph::addWeightedEdgeByVertices
  */
  public function testAddWeightedEdgeByVertices() {
    $graph = new WeightedGraph(['V1', 'V2']);
    $graph->addWeightedEdgeByVertices('V1', 'V2', 0.5);
    $this->assertEquals(
      [new WeightedEdge(0, 1, 0.5)],
      $graph->edgesForVertex('V1')
    );
  }

  /**
  * @covers WeightedGraph::addWeightedEdgeByVertices
  */
  public function testAddWeightedEdgeByVerticesExpectingException() {
    $graph = new WeightedGraph(['V1', 'V2']);
    try {
      $graph->addWeightedEdgeByVertices('V2', 'V3', 0.5);
      $this->fail('Expected InvalidArgumentException not thrown.');
    } catch(InvalidArgumentException $e) {
      $this->assertEquals(
        'Trying to add edge for vertices that are not in the graph.',
        $e->getMessage()
      );
    }
  }

  /**
  * @covers WeightedGraph::neighborsForIndexWithWeights
  */
  public function testNeighborsForIndexWithWeights() {
    $graph = new WeightedGraph(['V1', 'V2', 'V3']);
    $graph->addWeightedEdgeByVertices('V1', 'V2', 0.5);
    $graph->addWeightedEdgeByVertices('V2', 'V3', 0.7);
    $this->assertEquals(
      [['V1', 0.5], ['V3', 0.7]],
      $graph->neighborsForIndexWithWeights(1)
    );
  }

  /**
  * @covers WeightedGraph::__toString
  */
  public function testToString() {
    $graph = new WeightedGraph(['V1', 'V2', 'V3']);
    $graph->addWeightedEdgeByVertices('V1', 'V2', 0.5);
    $graph->addWeightedEdgeByVertices('V2', 'V3', 0.7);
    $this->assertEquals(
      "V1 -> V2 (0.50)\nV2 -> V1 (0.50), V3 (0.70)\nV3 -> V2 (0.70)\n",
      $graph->__toString()
    );
  }
}
