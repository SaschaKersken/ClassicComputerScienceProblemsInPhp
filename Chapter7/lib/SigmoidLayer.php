<?php

require_once(__DIR__.'/../../Util.php');

/**
* SigmoidLayer class
*
* A layer in which createNeuron() creates a SigmoidNeuron
* (i.e. a neuron using the sigmoid function as its activation function)
* and that subsequently uses the derivative sigmoid as its
* derivative activation function
*
* @package ClassicComputerScienceProblemsInPhp
*/
class SigmoidLayer extends Layer {
  /**
  * Create a neuron
  *
  * @param array $weights The neuron's weights
  * @param float $learningRate The neuron's learning rate
  * @return Neuron The newly created neuron, specifically a SigmoidNeuron
  */
  public function createNeuron(array $weights, float $learningRate): Neuron {
    return new SigmoidNeuron($weights, $learningRate);
  }

  /**
  * Derivative activation function (derivative sigmoid)
  *
  * @param float $x Value to calculate derivative sigmoid for
  * @return float Derivative sigmoid of input argument
  */
  public function derivativeActivationFunction(float $x): float {
    return NetworkUtils::derivativeSigmoid($x);
  }
}
