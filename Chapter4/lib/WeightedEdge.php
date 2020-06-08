<?php

require_once(__DIR__.'/../../Util.php');

/**
* WeightedEdge class
*
* Represents an edge with a weight attached to it.
* Vertices and weighted edges make up a WeightedGraph
*/
class WeightedEdge extends Edge {
  /**
  * The edge's weight
  * @var float
  */
  public $weight = 0.0;

  /**
  * Constructor
  *
  * @param int $u Index of the "from" vertex
  * @param int $v Index of the "to" vertex
  * @param float $weight The edge's weight
  */
  public function __construct(int $u, int $v, float $weight) {
    parent::__construct($u, $v);
    $this->weight = $weight;
  }

  /**
  * Reverse order of vertices
  *
  * @return WeightedEdge A new weighted edge with $u and $v reversed
  */
  public function reversed(): WeightedEdge {
    return new WeightedEdge($this->v, $this->u, $this->weight);
  }

  /**
  * String representation
  *
  * @return string The string representation
  */
  public function __toString(): string {
    return sprintf("%d (%.2f)> %d", $this->u, $this->weight, $this->v);
  }
}
