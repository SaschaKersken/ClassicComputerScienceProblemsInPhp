<?php

require_once(__DIR__.'/../Util.php');

$variables = ["Western Australia", "Northern Territory", "South Australia",
              "Queensland", "New South Wales", "Victoria", "Tasmania"];
$domains = [];
foreach ($variables as $variable) {
  $domains[$variable] = ["red", "green", "blue"];
}
$csp = new CSP($variables, $domains);
$csp->addConstraint(new MapColoringConstraint("Western Australia", "Northern Territory"));
$csp->addConstraint(new MapColoringConstraint("Western Australia", "South Australia"));
$csp->addConstraint(new MapColoringConstraint("South Australia", "Northern Territory"));
$csp->addConstraint(new MapColoringConstraint("Queensland", "Northern Territory"));
$csp->addConstraint(new MapColoringConstraint("Queensland", "South Australia"));
$csp->addConstraint(new MapColoringConstraint("Queensland", "New South Wales"));
$csp->addConstraint(new MapColoringConstraint("New South Wales", "South Australia"));
$csp->addConstraint(new MapColoringConstraint("Victoria", "South Australia"));
$csp->addConstraint(new MapColoringConstraint("Victoria", "New South Wales"));
$csp->addConstraint(new MapColoringConstraint("Victoria", "Tasmania"));
$solution = $csp->backtrackingSearch();
if (is_null($solution)) {
  Util::out('No solution found!');
} else {
  Util::out($solution);
}
