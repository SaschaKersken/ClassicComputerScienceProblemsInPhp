<?php

require_once(__DIR__.'/NetworkUtils.php');
require_once(__DIR__.'/Layer.php');
require_once(__DIR__.'/SigmoidNeuron.php');

class SigmoidLayer extends Layer {
  public function createNeuron(array $weights, float $learningRate) {
    return new SigmoidNeuron($weights, $learningRate);
  }

  public function derivativeActivationFunction(float $x): float {
    return NetworkUtils::derivativeSigmoid($x);
  }
}
