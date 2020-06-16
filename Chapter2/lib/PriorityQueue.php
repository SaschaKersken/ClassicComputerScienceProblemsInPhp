<?php

require_once(__DIR__.'/../../Autoloader.php');

/**
* PriorityQueue class
*
* Implementation of the priority queue data structure (in/out by priority)
*
* @package ClassicComputerScienceProblemsInPhp
* @see Queue
*/
class PriorityQueue extends Queue {
  /**
  * Are all elements of type node?
  * @var bool
  */
  private $onlyNodes = TRUE;

  /**
  * Push operation adds element and sorts the queue by priority
  *
  * @param mixed $item The item to push onto the stack
  */
  public function push($item) {
    if (!$this->isNode($item)) {
      $this->onlyNodes = FALSE;
    }
    $this->_container[] = $item;
    if ($this->onlyNodes) {
      // If all items are of type Node, use their compare() method for sorting
      usort(
        $this->_container,
        function ($a, $b) {
          return $a->compare($b);
        }
      );
    } else {
      // Otherwise use PHP's built-in sorting order
      sort($this->_container);
    }
  }

  /**
  * Pop operation
  *
  * Check whether all remaining items are nodes, let parent method handle the rest
  *
  * @return mixed Highest-priority item
  */
  public function pop() {
    $result = parent::pop();
    $this->onlyNodes = TRUE;
    foreach ($this->_container as $item) {
      if (!$this->isNode($item)) {
        $this->onlyNodes = FALSE;
        break;
      }
    }
    return $result;
  }

  /**
  * Internal helper method: Is this an object of type Node?
  *
  * @param mixed $item Item to test
  * @return bool TRUE if Node, otherwise FALSE
  */
  protected function isNode($item): bool {
    if (is_object($item) && get_class($item) == 'Node') {
      return TRUE;
    }
    return FALSE;
  }
}
