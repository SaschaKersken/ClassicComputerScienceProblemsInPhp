<?php

require_once(__DIR__.'/Network.php');
require_once(__DIR__.'/SigmoidLayer.php');

class SigmoidNetwork extends Network {
  public function createLayer($previousLayer, int $numNeurons, float $learningRate) {
    return new SigmoidLayer($previousLayer, $numNeurons, $learningRate);
  }
}
