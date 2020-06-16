<?php

require_once(__DIR__.'/../Autoloader.php');

$columns = [1, 2, 3, 4, 5, 6, 7, 8];
$rows = [];
foreach ($columns as $column) {
  $rows[$column] = [1, 2, 3, 4, 5, 6, 7, 8];
}
$csp = new CSP($columns, $rows);
$csp->addConstraint(new QueensConstraint($columns));
$solution = $csp->backTrackingSearch();
if (is_null($solution)) {
  Util::out("No solution found!");
} else {
  Util::out($solution);
}
