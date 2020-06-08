<?php

/**
* DijkstraNode class
*
* @package ClassicComputerScienceProblemsInPhp
*/
class DijkstraNode {
  /**
  * Distance of vertex from origin
  * @var float
  */
  public $distance;

  /**
  * Index of a vertex
  * @var int
  */
  public $vertex;

  /**
  * Constructor
  *
  * @param int $vertex Index of the vertex
  * @param float $distance Distance of the vertex from origin
  */
  public function __construct(int $vertex, float $distance) {
    $this->vertex = $vertex;
    $this->distance = $distance;
  }
}
