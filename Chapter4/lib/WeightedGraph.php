<?php

require_once(__DIR__.'/../../Util.php');

/**
* WeightedGraph class
*
* Represents a graph whose edges have weights, resulting in different path costs
*
* @package ClassicComputerScienceProblemsInPhp
*/
class WeightedGraph extends Graph {
  /**
  * Add a weighted edge using vertex indices
  *
  * @param int $u Index of the "from" vertex
  * @param int $v Index of the "to" vertex
  * @param float $weight Weight of this edge
  */
  public function addWeightedEdgeByIndices(int $u, int $v, float $weight) {
    $edge = new WeightedEdge($u, $v, $weight);
    $this->addEdge($edge);
  }

  /**
  * Add a weighted edge using vertices
  *
  * @param mixed $first The "from" vertex
  * @param mixed $second The "to" vertex
  * @throws InvalidArgumentException if any of the vertices doesn't exist
  */
  public function addWeightedEdgeByVertices($first, $second, float $weight) {
    $u = array_search($first, $this->_vertices);
    $v = array_search($second, $this->_vertices);
    if ($u === FALSE || $v === FALSE) {
      throw new InvalidArgumentException(
        'Trying to add edge for vertices that are not in the graph.'
      );
    }
    $this->addWeightedEdgeByIndices($u, $v, $weight);
  }

  /**
  * Find neighboring vertices with weights of their edges by vertex index
  *
  * @param int $index Index of the vertex to find neighbors for
  * @return array List of neighboring vertices with the weights of their edges
  */
  public function neighborsForIndexWithWeights(int $index): array {
    $distanceTuples = [];
    foreach ($this->edgesForIndex($index) as $edge) {
      $distanceTuples[] = [$this->vertexAt($edge->v), $edge->weight];
    }
    return $distanceTuples;
  }

  /**
  * Pretty-print the weighted graph
  *
  * @return string String representation of the graph
  */
  public function __toString(): string {
    $desc = '';
    foreach ($this->_vertices as $vertex) {
      $desc .= $vertex.' -> ';
      $distanceStrings = [];
      foreach ($this->neighborsForIndexWithWeights($this->indexOf($vertex)) as $n) {
        $distanceStrings[] = sprintf('%s (%.2f)', $n[0], $n[1]);
      }
      $desc .= implode(', ', $distanceStrings).PHP_EOL;
    }
    return $desc;
  }
}
