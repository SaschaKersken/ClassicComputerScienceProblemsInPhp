<?php

/**
* MazeLocation class
*
* Represents a specific location in a maze, indicated by row and column
* Implements {@see SearchState}
* 
* @package ClassicComputerScienceProblemsInPhp
*/
class MazeLocation implements SearchState {
  /**
  * Row
  * @var int
  */
  public $row = 0;

  /**
  * Column
  * @var int
  */
  public $column = 0;

  /**
  * Constructor
  *
  * @param int $row The row
  * @param int $column The column
  */
  public function __construct(int $row, int $column) {
    $this->row = $row;
    $this->column = $column;
  }

  /**
  * Get a representation of row and column that can be used as an array key
  *
  * @return string
  */
  public function getKey() {
    return sprintf('%d:%d', $this->row, $this->column);
  }
}
