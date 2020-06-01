<?php

require_once(__DIR__.'/Layer.php');

abstract class Network {
  private $layers = [];

  public function __construct(array $layerStructure, float $learningRate) {
    if (count($layerStructure) < 3) {
      throw new InvalidArgumentException("Error: Should be at least 3 layers (1 input, 1 hidden, 1 output)");
    }
    $inputLayer = $this->createLayer(NULL, $layerStructure[0], $learningRate);
    $this->layers[] = $inputLayer;
    foreach (array_slice($layerStructure, 1) as $previous => $numNeurons) {
      $nextLayer = $this->createLayer($this->layers[$previous], $numNeurons, $learningRate);
      $this->layers[] = $nextLayer;
    }
  }

  public function outputs(array $input): array {
    return array_reduce(
      $this->layers,
      function ($inputs, $layer) {
        return $layer->outputs($inputs);
      },
      $input
    );
  }

  public function backPropagate(array $expected) {
    $lastLayer = count($this->layers) - 1;
    $this->layers[$lastLayer]->calculateDeltasForUtilLayer($expected);
    for ($l = $lastLayer - 1; $l > 0; $l--) {
      $this->layers[$l]->calculateDeltasForHiddenLayer($this->layers[$l + 1]);
    }
  }

  public function updateWeights() {
    foreach (array_slice($this->layers, 1) as $layer) {
      foreach ($layer->neurons as $neuron) {
        for ($w = 0; $w < count($neuron->weights); $w++) {
          $neuron->weights[$w] += $neuron->learningRate * $layer->previousLayer->outputCache[$w] * $neuron->delta;
        }
      }
    }
  }

  public function train(array $inputs, array $expecteds) {
    foreach ($inputs as $location => $xs) {
      $ys = $expecteds[$location];
      $outs = $this->outputs($xs);
      $this->backPropagate($ys);
      $this->updateWeights();
    }
  }

  public function validate(array $inputs, array $expecteds, callable $interpretUtil): array {
    $correct = 0;
    for ($i = 0; $i < count($inputs); $i++) {
      $input = $inputs[$i];
      $expected = $expecteds[$i];
      $result = $interpretUtil($this->outputs($input));
      if ($result == $expected) {
        $correct++;
      }
    }
    $percentage = (float)$correct / count($inputs);
    return [$correct, count($inputs), $percentage];
  }

  public abstract function createLayer($previousLayer, int $numNeurons, float $learningRate);
}
