<?php

/**
* Node class
*
* Represents a node in depth-first, breadth-first, and A* searches
*
* @package ClassicComputerScienceProblemsInPhp
* @property mixed $state State represented by this node
* @property mixed $parent parent Node or NULL if none
* @property float $cost Cost this node adds to the total cost of the current path
* @property float $heuristic Estimated cost for reaching thise node
*/
class Node {
  /**
  * Current state of the search space represented by this node
  * @var mixed
  */
  private $state = NULL;

  /**
  * Parent node (NULL for base/first node)
  * @var mixed NULL or Node
  */
  private $parent = NULL;

  /**
  * Cost this node adds to the total cost of the current path (for A* search)
  * @var float
  */
  private $cost = 0.0;

  /**
  * Estimated cost for reaching this node (for A* search)
  * @var float
  */
  private $heuristic = 0.0;

  /**
  * Constructor
  *
  * @param mixed $state The state to be represented by thise node
  * @param mixed $parent optional, default NULL; parent node if present
  * @param float $cost optional, default 0.0 (unused in dfs and bfs)
  * @param float $heuristic optional, default 0.0 (unused in dfs and bfs)
  */
  public function __construct($state, $parent = NULL, $cost = 0.0, $heuristic = 0.0) {
    $this->state = $state;
    $this->parent = $parent;
    $this->cost = $cost;
    $this->heuristic = $heuristic;
  }

  /**
  * Compare this node to another one
  *
  * @param Node $other Node to compare this one to
  * @return int -1 if $this < $other, 1 if $this > $other, 0 if $this == $other
  */
  public function compare(Node $other): int {
    if ($this->cost + $this->heuristic < $other->cost + $other->heuristic) {
      return -1;
    }
    if ($this->cost + $this->heuristic > $other->cost + $other->heuristic) {
      return 1;
    }
    return 0;
  }

  /**
  * Magic getter method
  *
  * @param string $property
  * @return mixed See property declarations for details
  */
  public function __get($property) {
    switch ($property) {
    case 'state':
      return $this->state;
    case 'parent':
      return $this->parent;
    case 'cost':
      return $this->cost;
    case 'heuristic':
      return $this->heuristic;
    }
  }
}
