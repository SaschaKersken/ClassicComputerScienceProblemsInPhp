<?php

require_once(__DIR__.'/csp.php');
require_once(__DIR__.'/../Output.php');

class MapColoringConstraint extends Constraint {
  private $place1 = '';
  private $place2 = '';

  public function __construct(string $place1, string $place2) {
    parent::__construct([$place1, $place2]);
    $this->place1 = $place1;
    $this->place2 = $place2;
  }

  public function satisfied(array $assignment): bool {
    if (!array_key_exists($this->place1, $assignment) || !array_key_exists($this->place2, $assignment)) {
      return TRUE;
    }
    return $assignment[$this->place1] != $assignment[$this->place2];
  }
}

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
  Output::out('No solution found!');
} else {
  Output::out($solution);
}
