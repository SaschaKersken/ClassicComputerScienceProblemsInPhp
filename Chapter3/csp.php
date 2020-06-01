<?php

/**
* Constraint satisfaction problem class
*
* A constraint satisfaction problem consists of variables
* that have ranges of values known as domains and constraints
* that determine whether a particular variable's domain selection is valid
*
* @package ClassicComputerScienceProblemsInPhp
*/
class CSP {
  /**
  * Variables
  * @var array
  */
  private $variables = [];

  /**
  * Domains (possible values for variables)
  * @var array
  */
  private $domains = [];

  /**
  * Constraints the variables need to satisfy
  * @var array
  */
  private $constraints = [];

  /**
  * Constructor
  *
  * @param array $variables The variables
  * @param array $domains Domains for the variables
  * @throws InvalidArgumentException if a variable has no domain assigned to it
  */
  public function __construct(array $variables, array $domains) {
    $this->variables = $variables;
    $this->domains = $domains;
    foreach ($this->variables as $variable) {
      $this->constraints[$variable] = [];
      if (!array_key_exists($variable, $domains)) {
        throw new InvalidArgumentException(
          'Every variable should have a domain assigned to it.'
        );
      }
    }
  }

  /**
  * Add a constraint
  *
  * @param Constraint $constraint
  * @throws InvalidArgumentException if a variable is not part of the CSP
  */
  public function addConstraint(Constraint $constraint) {
    foreach ($constraint->variables as $variable) {
      if (!in_array($variable, $this->variables)) {
        throw new InvalidArgumentException('Variable in constraint not in CSP.');
      } else {
        $this->constraints[$variable][] = $constraint;
      }
    }
  }

  /**
  * Check for consistency
  *
  * Check if the value assignment is consistent by checking all constraints
  * for the given variable against it
  *
  * @param mixed $variable The variable to check
  * @param mixed $assignment The assigment to check against
  * @return bool TRUE if the constraints are satisfied, otherwise FALSE
  */
  public function consistent($variable, $assignment): bool {
    foreach ($this->constraints[$variable] as $constraint) {
      if (!$constraint->satisfied($assignment)) {
        return FALSE;
      }
    }
    return TRUE;
  }

  /**
  * Backtracking search
  *
  * @param array $assignment
  */
  public function backtrackingSearch(array $assignment = []) {
    // assignment is complete if every variable is assigned (our base case)
    if (count($assignment) == count($this->variables)) {
      return $assignment;
    }

    // get all variables in the CSP but not in the assignment
    $unassigned = array_filter(
      $this->variables,
      function($v) use($assignment) {
        return !array_key_exists($v, $assignment);
      }
    );

    // get every possible domain value of the first unassigned variable
    $first = array_values($unassigned)[0];
    foreach ($this->domains[$first] as $value) {
      $localAssignment = $assignment;
      $localAssignment[$first] = $value;
      // if we're still consistent, we recurse (continue)
      if ($this->consistent($first, $localAssignment)) {
        $result = $this->backTrackingSearch($localAssignment);
        // if we didn't find the result, we will end up backtracking
        if (!is_null($result)) {
          return $result;
        }
      }
    }
    return NULL;
  }
}
