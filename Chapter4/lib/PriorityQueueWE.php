<?php

/**
* PriorityQueueWE class
*
* Use SplPriorityQueue for WeightedEdge objects
* Conveniently provide an empty property, push() and pop() methods
* instead of SplPriorityQueue's isEmpty(), insert(), and extract()
* in order to keep the examples more consistent
*
* @package ClassicComputerScienceProblemsInPhp
* @see SplPriorityQueue
*/
class PriorityQueueWE extends SplPriorityQueue {
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
  * Using the edges' negative weight because we want the smallest first
  *
  * @param WeightedEdge $we The edge to insert into the priority queue
  */
  public function push(WeightedEdge $edge) {
    parent::insert($edge, -$edge->weight);
  }

  /**
  * Pop operation
  *
  * @return WeightedEdge The highest-priority edge
  */
  public function pop(): WeightedEdge {
    return parent::extract();
  }
}
