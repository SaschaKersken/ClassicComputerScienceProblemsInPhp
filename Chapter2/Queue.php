<?php

require_once(__DIR__.'/../Util.php');

/**
* Queue class
*
* Represents the queue data structure (FIFO = first in, first out)
*
* @package ClassicComputerScienceProblemsInPhp
* @see Stack
*/
class Queue extends Stack {
  /**
  * Pop operation
  *
  * @return mixed The item popped from the stack (which was the first one pushed)
  */
  public function pop() {
    return array_shift($this->_container);
  }
}
