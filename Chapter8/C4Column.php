<?php

require_once(__DIR__.'/C4Piece.php');
require_once(__DIR__.'/C4Board.php');

class C4Column implements ArrayAccess {
  private $_container = [];

  public function full(): bool {
    return count($this->_container) >= C4Board::NUM_ROWS;
  }

  public function push(C4Piece $item) {
    if ($this->full()) {
      throw new OverflowException('Trying to push piece to full column');
    }
    $this->_container[] = $item;
  }

  public function offsetExists($offset): bool {
    if ($offset < C4Board::NUM_ROWS) {
      return TRUE;
    }
    return FALSE;
  }

  public function offsetGet($offset): C4Piece {
    if (isset($this->_container[$offset])) {
      return $this->_container[$offset];
    }
    return new C4Piece(C4Piece::E);
  }

  public function offsetSet($offset, $value) {
    if (is_null($offset)) {
      $this->push($value);
    } else {
      throw new InvalidArgumentException('Setting elements by specific key prohibited');
    }
  }

  public function offsetUnset($offset) {
    throw new BadMethodCallException('Unsetting elements is prohibited');
  }

  public function __toString(): string {
    return implode(', ', $this->_container);
  }
} 
