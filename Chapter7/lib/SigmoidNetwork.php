<?php

require_once(__DIR__.'/../../Autoloader.php');

/**
* SigmoidNetwork class
*
* Artificial neural network that uses layers of type SigmoidLayer
*
* @package ClassicComputerScienceProblemsInPhp
*/
class SigmoidNetwork extends Network {
  /**
  * Create a layer
  *
  * @param mixed $previousLayer Previous layer (Layer) or NULL if input layer
  * @param int $numNeurons Number of neurons in this layer
  * @return Layer, in this case SigmoidLayer
  */
  public function createLayer($previousLayer, int $numNeurons,
    float $learningRate): Layer {
    return new SigmoidLayer($previousLayer, $numNeurons, $learningRate);
  }
}
