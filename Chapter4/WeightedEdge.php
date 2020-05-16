<?php

require_once(__DIR__.'/Edge.php');

class WeightedEdge extends Edge {
  public $weight = 0.0;

  public function __construct(int $u, int $v, float $weight) {
    parent::__construct($u, $v);
    $this->weight = $weight;
  }

  public function reversed(): WeightedEdge {
    return new WeightedEdge($this->v, $this->u, $this->weight);
  }

  public function __toString(): string {
    return sprintf("%d (%f)> %d", $this->u, $this->weight, $this->v);
  }
}
