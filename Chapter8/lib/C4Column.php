<?php

require_once(__DIR__.'/../../Autoloader.php');

/**
* C4Column class
*
* Column in a Connect Four game
*
* @package ClassiComputerScienceProblemsInPhp
*/
class C4Column implements ArrayAccess {
  /**
  * The internal container
  * @var array
  */
  private $_container = [];

  /**
  * Is the column full?
  *
  * @return bool TRUE if full, otherwise FALSE
  */
  public function full(): bool {
    return count($this->_container) >= C4Board::NUM_ROWS;
  }

  /**
  * Push a piece into the column
  *
  * @param C4Piece The piece to push
  * @throws OverflowException if column full
  */
  public function push(C4Piece $item) {
    if ($this->full()) {
      throw new OverflowException('Trying to push piece to full column');
    }
    $this->_container[] = $item;
  }

  /**
  * Is an item set at a specific offset?
  *
  * Will be invoked by isset($this[$offset]) via ArrayAccess
  *
  * @param mixed $offset The index to check an item at
  * @return bool TRUE if the item exists, otherwise FALSE
  */
  public function offsetExists($offset): bool {
    if ($offset < C4Board::NUM_ROWS) {
      return TRUE;
    }
    return FALSE;
  }

  /**
  * Retrieve the item at a specific offset
  *
  * Will be invoked by reading $this[$offset] via ArrayAccess
  *
  * @param mixed $offset The index to retrieve an item at
  * @return C4Piece The C4Piece at the position or an empty one if unset
  */
  public function offsetGet($offset): C4Piece {
    if (isset($this->_container[$offset])) {
      return $this->_container[$offset];
    }
    return new C4Piece(C4Piece::E);
  }

  /**
  * Insert a new item
  *
  * Will be invoked by writing $this[] without a specific offset
  *
  * @param mixed $offset Must be NULL
  * @throws InvalidArgumentException if a specific offset is used
  * @param C4Piece $value The piece to insert
  */
  public function offsetSet($offset, $value) {
    if (is_null($offset)) {
      $this->push($value);
    } else {
      throw new InvalidArgumentException('Setting elements by specific key prohibited');
    }
  }

  /**
  * Remove an item
  *
  * Would be invoked by unset($this[$offset]), but must not be used
  * Required by implementing ArrayAccess
  *
  * @param mixed $offset The offset not to use
  * @throws BadMethodCallException if invoked
  */
  public function offsetUnset($offset) {
    throw new BadMethodCallException('Unsetting elements is prohibited');
  }

  /**
  * String representation
  *
  * @return string The string representation
  */
  public function __toString(): string {
    return implode(', ', $this->_container);
  }
} 
