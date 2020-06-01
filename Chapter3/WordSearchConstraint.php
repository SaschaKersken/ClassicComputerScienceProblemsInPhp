<?php

/**
* WordSearchConstraint class
*
* Make sure words do not overlap each other in a grid
*
* @package ClassicComputerScienceProblemsInPhp
*/
class WordSearchConstraint extends Constraint {
  /**
  * List of words
  * @var array
  */
  private $words = [];

  /**
  * Constructor
  *
  * @param array $words The list of words to use
  */
  public function __construct(array $words) {
    parent::__construct($words);
    $this->words = $words;
  }

  /**
  * Check whether an assignment is satisfied
  *
  * @param array $assignment The assignment to check
  * @return bool TRUE if satisfied, otherwise FALSE
  */
  public function satisfied(array $assignment): bool {
    // if there are any duplicates grid locations then there is an overlap
    $allLocations = [];
    foreach ($assignment as $values) {
      foreach ($values as $locs) {
        $allLocations[] = $locs;
      }
    }
    return count($this->unique($allLocations)) == count($allLocations);
  }

  /**
  * Helper method that makes a nested array unique
  *
  * @param array $array The array to make unique
  * @return array The processed array
  */
  private function unique(array $array): array {
    return array_map(
      'unserialize',
      array_unique(array_map('serialize', $array))
    );
  }
}
