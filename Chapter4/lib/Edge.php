<?php

/**
* Edge class
*
* Represents an edge in a graph
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Edge {
  /**
  * The "from" vertex
  * @var int
  */
  public $u;

  /**
  * The "to" vertex
  * @var int
  */
  public $v;

  /**
  * Constructor
  *
  * @param int $u "From" vertex
  * @param int $v "Two" vertex
  */
  public function __construct(int $u, int $v) {
    $this->u = $u;
    $this->v = $v;
  }

  /**
  * Return a new edge with reversed vertices
  *
  * @return Edge
  */
  public function reversed(): Edge {
    return new Edge($this->v, $this->u);
  }

  /**
  * String representation
  *
  * @return string
  */
  public function __toString(): string {
    return sprintf('%d -> %d', $this->u, $this->v);
  }
}
