<?php

/**
* GridLocation class
*
* @package ClassicComputerScienceProblemsInPhp
*/
class GridLocation {
  /**
  * Row
  * @var int
  */
  public int $row;

  /**
  * Column
  * @var int
  */
  public int $column;

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
}
