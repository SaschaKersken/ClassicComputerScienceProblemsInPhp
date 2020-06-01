<?php

require_once(__DIR__.'/NetworkUtils.php');
require_once(__DIR__.'/Neuron.php');

abstract class Layer {
  public $previousLayer = NULL;
  public $neurons = [];
  public $outputCache = [];
private $counter = 0;

  public function __construct($previousLayer, int $numNeurons, float $learningRate) {
    $this->previousLayer = $previousLayer;
    $this->neurons = [];
    for ($i = 0; $i < $numNeurons; $i++) {
      if (is_null($previousLayer)) {
        $randomWeights = [];
      } else {
        $randomWeights = array_map(
          function () {
            return (float)rand() / getrandmax();
          },
          range(0, count($previousLayer->neurons) - 1)
        );
      }
      $neuron = $this->createNeuron($randomWeights, $learningRate);
      $this->neurons[] = $neuron;
    }
    $this->outputCache = array_fill(0, $numNeurons - 1, 0.0);
  }

  public function outputs(array $inputs): array {
    if (is_null($this->previousLayer)) {
      $this->outputCache = $inputs;
    } else {
      $this->outputCache = array_map(
        function ($n) use($inputs) {
          return $n->output($inputs);
        },
        $this->neurons
      );
    }
    return $this->outputCache;
  }

  public function calculateDeltasForUtilLayer(array $expected) {
    for ($n = 0; $n < count($this->neurons); $n++) {
      $this->neurons[$n]->delta = $this->derivativeActivationFunction(
        $this->neurons[$n]->outputCache
      ) * ($expected[$n] - $this->outputCache[$n]);
    }
  }

  public function calculateDeltasForHiddenLayer(Layer $nextLayer) {
    foreach ($this->neurons as $index => $neuron) {
      $nextWeights = array_map(
        function ($n) use($index) {
          return $n->weights[$index];
        },
        $nextLayer->neurons
      );
      $nextDeltas = array_map(
        function ($n) {
          return $n->delta;
        },
        $nextLayer->neurons
      );
      $sumWeightsAndDeltas = NetworkUtils::dotProduct($nextWeights, $nextDeltas);
      $neuron->delta = $this->derivativeActivationFunction(
        $neuron->outputCache
      ) * $sumWeightsAndDeltas;
    }
  }

  public abstract function createNeuron(array $weights, float $learningRate);

  public abstract function derivativeActivationFunction(float $x): float;
}
