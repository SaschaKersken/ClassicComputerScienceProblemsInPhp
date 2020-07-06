<?php

/**
* PriorityQueue class
*
* Use SplPriorityQueue for Node objects
* Conveniently provide an empty property, push() and pop() methods
* instead of SplPriorityQueue's isEmpty(), insert(), and extract()
* in order to keep the examples more consistent
*
* @package ClassicComputerScienceProblemsInPhp
* @see SplPriorityQueue
*/
class PriorityQueue extends SplPriorityQueue {
  /**
  * Magic getter
  *
  * @param string $property Property to read
  * @return mixed Value of the property
  */
  public function __get($property) {
    if ($property == 'empty') {
      return $this->isEmpty();
    }
  }

  /**
  * Push operation
  *
  * @param Node $node The node to insert into the priority queue
  */
  public function push(Node $node) {
    parent::insert($node, $this->getPriority($node));
  }

  /**
  * Pop operation
  *
  * @return Node The highest-priority node
  */
  public function pop(): Node {
    return parent::extract();
  }

  /**
  * Get priority for a node
  *
  * Using the negative value because we want the node
  * with the lowest cost + heuristic first
  *
  * @param Node $node The node to get the priority value for
  * @return float The priority
  */
  protected function getPriority(Node $node): float {
    return -($node->cost + $node->heuristic);
  }
}
