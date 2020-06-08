<?php

require_once(__DIR__.'/../../Util.php');

/**
* QueensConstraint class
*
* Make sure that two queens on a chess board do not threaten each other
*
* @package ClassicComputerScienceProblemsInPhp
*/
class QueensConstraint extends Constraint {
  /**
  * Columns the queens are in
  * @var array
  */
  private $columns = [];

  /**
  * Constructor
  *
  * @param array $columns Columns the queens are in
  */
  public function __construct(array $columns) {
    parent::__construct($columns);
    $this->columns = $columns;
  }

  /**
  * Make sure the queens are not in the same row, column, or diagonal
  *
  * @param array $assignment Value assignment to check
  * @return bool TRUE if satisfied, otherwise FALSE
  */
  public function satisfied(array $assignment): bool {
    // q1c = queen 1 column, q1r = queen 1 row
    foreach ($assignment as $q1c => $q1r) {
      // q2c = queen 2 column
      for ($q2c = $q1c + 1; $q2c <= count($this->columns) + 2; $q2c++) {
        if (array_key_exists($q2c, $assignment)) {
          $q2r = $assignment[$q2c]; // q2r = queen 2 row
          if ($q1r == $q2r) { // same row?
            return FALSE;
          }
          if (abs($q1r - $q2r) == abs($q1c - $q2c)) { // same diagonal?
            return FALSE;
          }
        }
      }
    }
    return TRUE; // no conflict
  }
}
