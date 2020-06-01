<?php

/**
* Stack class
*
* Representation of the stack data structure (LIFO = last in, first out)
*
* @package ClassicComputerScienceProblemsInPhp
* @property bool $empty Whether the stack is empty
*/
class Stack {
  /**
  * Internal data container
  * @var array
  */
  protected $_container = [];

  /**
  * Magic getter method
  *
  * @param string $key
  * @return bool for key 'empty': TRUE if empty, FALSE if not
  */
  public function __get($key) {
    if ($key == 'empty') {
      return !$this->_container; // not is TRUE for empty container
    }
  }

  /**
  * Push operation
  *
  * @param mixed $item The item to push onto the stack
  */
  public function push($item) {
    $this->_container[] = $item;
  }

  /**
  * Pop operation
  *
  * @return mixed The item popped from the stack (which was the last one pushed)
  */
  public function pop() {
    return array_pop($this->_container); // LIFO
  }

  public function __toString() {
    return implode(', ', $this->_container);
  }
}
