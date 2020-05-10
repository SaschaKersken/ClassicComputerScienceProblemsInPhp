<?php

require_once(__DIR__.'/csp.php');
require_once(__DIR__.'/../Output.php');

class QueensConstraint extends Constraint {
  private $columns = [];

  public function __construct(array $columns) {
    parent::__construct($columns);
    $this->columns = $columns;
  }

  public function satisfied(array $assignment): bool {
    foreach ($assignment as $q1c => $q1r) {
      for ($q2c = $q1c + 1; $q2c <= count($this->columns) + 2; $q2c++) {
        if (array_key_exists($q2c, $assignment)) {
          $q2r = $assignment[$q2c];
          if ($q1r == $q2r) {
            return FALSE;
          }
          if (abs($q1r - $q2r) == abs($q1c - $q2c)) {
            return FALSE;
          }
        }
      }
    }
    return TRUE;
  }
}

$columns = [1, 2, 3, 4, 5, 6, 7, 8];
$rows = [];
foreach ($columns as $column) {
  $rows[$column] = [1, 2, 3, 4, 5, 6, 7, 8];
}
$csp = new CSP($columns, $rows);
$csp->addConstraint(new QueensConstraint($columns));
$solution = $csp->backTrackingSearch();
if (is_null($solution)) {
  Output::out("No solution found!");
} else {
  Output::out($solution);
}
