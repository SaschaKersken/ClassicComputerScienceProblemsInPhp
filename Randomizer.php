<?php

/**
* Randomizer class
*
* Utility class to be dependency-injected for two reasons:
* 1. Can be replaced with a better source of randomness/entropy if necessary
* 2. Can be mocked for unit-testing
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Randomizer {
  /**
  * Get a random floating-point number between 0 and 1
  *
  * @return float Random floating-point number
  */
  public function randomFloat() {
    return (float)rand() / (float)getrandmax();
  }
}
