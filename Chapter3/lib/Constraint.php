<?php

/**
* Constraint class
*
* Base class for all constraints
*
* @package ClassicComputerScienceProblemsInPhp
*/
abstract class Constraint {
  /**
  * Variables in this constraint
  * @var array
  */
  public $variables = [];

  /**
  * Constructor
  *
  * @param array $variables The variables this constraint is for
  */
  public function __construct(array $variables) {
    $this->variables = $variables;
  }

  /**
  * Check whether the variables satisfy the given assignment
  *
  * Must be overridden by subclasses
  *
  * @param array $assignment The assignment to check the variables against
  * @return bool TRUE if satisfied, otherwise FALSE
  */
  abstract protected function satisfied(array $assignment): bool;
}
