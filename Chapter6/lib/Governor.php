<?php

require_once(__DIR__.'/../../Util.php');

/**
* Governor class
*
* Two-dimensional data point with age and state longitude of a US governor
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Governor extends DataPoint {
  /**
  * Longitude of the governor's state
  * @var float
  */
  private $longitude = 0.0;

  /**
  * The governor's age
  * @var float
  */
  private $age = 0.0;

  /**
  * Human-readable representation of the governor's state
  * @var string
  */
  private $state = '';

  /**
  * Constructor
  *
  * @param float $longitude State longitude
  * @param float $age The governor's age
  * @param string $state The governor's state
  */
  public function __construct(float $longitude, float $age, string $state) {
    parent::__construct([$longitude, $age]);
    $this->longitude = $longitude;
    $this->age = $age;
    $this->state = $state;
  }

  /**
  * Get the string representation
  *
  * @return string String representation
  */
  public function __toString(): string {
    return sprintf(
      '%s: (longitude: %.6f, age: %d)',
      $this->state,
      $this->longitude,
      $this->age
    );
  }
}
