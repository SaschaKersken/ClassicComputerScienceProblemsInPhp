<?php

require_once(__DIR__.'/Graph.php');
require_once(__DIR__.'/WeightedEdge.php');

class WeightedGraph extends Graph {
  public function addWeightedEdgeByIndices(int $u, int $v, float $weight) {
    $edge = new WeightedEdge($u, $v, $weight);
    $this->addEdge($edge);
  }

  public function addWeightedEdgeByVertices($first, $second, float $weight) {
    $u = array_search($first, $this->_vertices);
    $v = array_search($second, $this->_vertices);
    if ($u === FALSE || $v === FALSE) {
      throw new InvalidArgumentException('Trying to add edge for vertices that are not in the graph.');
    }
    $this->addWeightedEdgeByIndices($u, $v, $weight);
  }

  public function neighborsForIndexWithWeights(int $index): array {
    $distanceTuples = [];
    foreach ($this->edgesForIndex($index) as $edge) {
      $distanceTuples[] = [$this->vertexAt($edge->v), $edge->weight];
    }
    return $distanceTuples;
  }

  public function __toString(): string {
    $desc = '';
    foreach ($this->_vertices as $vertex) {
      $desc .= $vertex.' -> ';
      $distanceStrings = [];
      foreach ($this->neighborsForIndexWithWeights($this->indexOf($vertex)) as $n) {
        $distanceStrings[] = sprintf('%s (%d)', $n[0], $n[1]);
      }
      $desc .= implode(', ', $distanceStrings).PHP_EOL;
    }
    return $desc;
  }
}
