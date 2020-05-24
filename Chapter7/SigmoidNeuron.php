<?php

require_once(__DIR__.'/Neuron.php');
require_once(__DIR__.'/NetworkUtils.php');

class SigmoidNeuron extends Neuron {
  public function activationFunction(float $x): float {
    return NetworkUtils::sigmoid($x);
  }
}
