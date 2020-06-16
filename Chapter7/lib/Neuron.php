<?php

require_once(__DIR__.'/../../Autoloader.php');

/**
* Neuron class
*
* Represents the smallest entity in an artificial neural network
*
* @package ClassicComputerScienceProblemsInPhp
*/
abstract class Neuron {
  /**
  * Weights: Values to modify the input value towards a specific result
  * @var array
  */
  public $weights = [];

  /**
  * Output cache: result before applying the activation function
  * @var float
  */
  public $outputCache = 0.0;

  /**
  * Delta: difference between expected result and actual result
  * @var float
  */
  public $delta = 0.0;

  /**
  * Learning rate
  * @var float
  */
  public $learningRate = 0.0;

  /**
  * Constructor
  *
  * @param array $weights The weights
  * @param float $learningRate The learning rate
  */
  public function __construct(array $weights, float $learningRate) {
    $this->weights = $weights;
    $this->learningRate = $learningRate;
    $this->outputCache = 0.0;
    $this->delta = 0.0;
  }

  /**
  * Calculate the neuron's output
  *
  * First calculate the dot product of inpput values and weights
  * Then cache this result and apply the activation function to it
  *
  * @return float Result of both steps
  */
  public function output(array $inputs): float {
    $this->outputCache = NetworkUtils::dotProduct($inputs, $this->weights);
    return $this->activationFunction($this->outputCache);
  }

  /**
  * Activation function
  *
  * Must be overridden by child classes
  */
  public abstract function activationFunction(float $x): float;
}
