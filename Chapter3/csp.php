<?php

abstract class Constraint {
  public $variables = [];

  public function __construct(array $variables) {
    $this->variables = $variables;
  }

  abstract protected function satisfied(array $assignment): bool;
}

class CSP {
  private $variables = [];
  private $domains = [];
  private $constraints = [];

  public function __construct(array $variables, array $domains) {
    $this->variables = $variables;
    $this->domains = $domains;
    foreach ($this->variables as $variable) {
      $this->constraints[$variable] = [];
      if (!array_key_exists($variable, $domains)) {
        throw new InvalidArgumentException('Every variable should have a domain assigned to it.');
      }
    }
  }

  public function addConstraint(Constraint $constraint) {
    foreach ($constraint->variables as $variable) {
      if (!in_array($variable, $this->variables)) {
        throw new InvalidArgumentException('Variable in constraint not in CSP.');
      } else {
        $this->constraints[$variable][] = $constraint;
      }
    }
  }

  public function consistent($variable, $assignment): bool {
    foreach ($this->constraints[$variable] as $constraint) {
      if (!$constraint->satisfied($assignment)) {
        return FALSE;
      }
    }
    return TRUE;
  }

  public function backtrackingSearch(array $assignment = []) {
    if (count($assignment) == count($this->variables)) {
      return $assignment;
    }
    $unassigned = array_filter(
      $this->variables,
      function($v) use($assignment) {
        return !array_key_exists($v, $assignment);
      }
    );
    $first = array_values($unassigned)[0];
    foreach ($this->domains[$first] as $value) {
      $localAssignment = $assignment;
      $localAssignment[$first] = $value;
      if ($this->consistent($first, $localAssignment)) {
        $result = $this->backTrackingSearch($localAssignment);
        if (!is_null($result)) {
          return $result;
        }
      }
    }
    return NULL;
  }
}
