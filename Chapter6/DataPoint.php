<?php

/**
* DataPoint class
*
* @package ClassicComputerScienceProblemsInPhp
* @property int $numDimensions Number of dimensions
*/
class DataPoint {
  /**
  * Original dimension values
  * @var array
  */
  private $_originals = [];

  /**
  * Dimension values that will be subject to feature scaling
  * @var array
  */
  public $dimensions = [];

  /**
  * Constructor
  *
  * @param array The original dimension values
  */
  public function __construct(array $initial) {
    $this->_originals = $initial;
    $this->dimensions = $initial;
  }

  /**
  * Magic getter method
  *
  * @param string $property
  * @return mixed Property value
  */
  public function __get(string $property) {
    if ($property == 'numDimensions') {
      return count($this->dimensions);
    }
  }

  /**
  * Calculate distance to another data point
  *
  * @param DataPoint $other Data point to calculate distance to
  * @return float The distance
  */
  public function distance(DataPoint $other): float {
    $combined = array_map(NULL, $this->dimensions, $other->dimensions);
    $differences = array_map(
      function($e) {
        return ($e[0] - $e[1]) ** 2;
      },
      $combined
    );
    return sqrt(array_sum($differences));
  }

  /**
  * String representation
  *
  * @return string The string representation
  */
  public function __toString(): string {
    return implode(', ', $this->_originals);
  }
}
