<?php

require_once(__DIR__.'/../Util.php');

/**
* Map coloring constraint class
*
* @package ClassicComputerScienceProblemsInPhp
*/
class MapColoringConstraint extends Constraint {
  /**
  * First place to color
  * @var string
  */
  private $place1 = '';

  /**
  * Second (neighboring) place to color
  * @var string
  */
  private $place2 = '';

  /**
  * Constructor
  *
  * @param string $place1 First place to color
  * @param string $place2 Second (neighboring) place to color
  */
  public function __construct(string $place1, string $place2) {
    parent::__construct([$place1, $place2]);
    $this->place1 = $place1;
    $this->place2 = $place2;
  }

  /**
  * Satisfied if the two places' colors are different
  *
  * @param array $assignment The value assignment to check
  * @return bool TRUE if satisfied, otherwise FALSE
  */
  public function satisfied(array $assignment): bool {
    // If either place is not in the assignment then it is not
    // yet possible for their colors to be conflicting
    if (!array_key_exists($this->place1, $assignment) ||
        !array_key_exists($this->place2, $assignment)) {
      return TRUE;
    }
    // Check the color assigned to place1 is not the same as the
    // color assigned to place2
    return $assignment[$this->place1] != $assignment[$this->place2];
  }
}
