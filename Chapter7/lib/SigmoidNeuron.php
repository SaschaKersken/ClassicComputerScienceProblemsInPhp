<?php

require_once(__DIR__.'/../../Util.php');

/**
* SigmoidNeuron class
*
* A neuron whose activation function is the classic sigmoid function
*
* @package ClassicComputerScienceProblemsInPhp
*/
class SigmoidNeuron extends Neuron {
  /**
  * Activation function: the sigmoid function
  *
  * @param float $x Value to apply the function to
  * @return float Result of the sigmoid function
  */
  public function activationFunction(float $x): float {
    return NetworkUtils::sigmoid($x);
  }
}
