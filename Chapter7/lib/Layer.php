<?php

require_once(__DIR__.'/../../Util.php');

/**
* Layer class
*
* Represents a layer in an artificial neural network
*
* @package ClassicComputerScienceProblemsInPhp
*/
abstract class Layer {
  /**
  * Previous layer (input for this one)
  * @var mixed NULL if this is the input layer, otherwise Layer
  */
  public $previousLayer = NULL;

  /**
  * This layer's neurons
  * @var array
  */
  public $neurons = [];

  /**
  * This layer's output cache
  * @var array
  */
  public $outputCache = [];

  /**
  * Constructor
  *
  * @param mixed $previousLayer The previous Layer or NULL if input layer
  * @param int $numNeurons How many neurons to create for this layer
  * @param float $learningRate The learning rate
  */
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

  /**
  * Calculate outputs using the layer's neurons
  *
  * @param array $inputs Input values (from previous layer, or user if input layer)
  * @return array Values after calculation
  */
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

  /**
  * Calculate deltas for output layer
  *
  * Should only be called on output layer
  *
  * @param array $expected Expected values
  */
  public function calculateDeltasForOutputLayer(array $expected) {
    for ($n = 0; $n < count($this->neurons); $n++) {
      $this->neurons[$n]->delta = $this->derivativeActivationFunction(
        $this->neurons[$n]->outputCache
      ) * ($expected[$n] - $this->outputCache[$n]);
    }
  }

  /**
  * Calculate deltas for hidden layer
  *
  * Should not be called on output layer
  *
  * @param Layer $nextLayer Next layer to retrieve deltas from
  */
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

  /**
  * Create a neuron
  *
  * Has to be overridden by child classes to determine the type of neuron
  *
  * @param array $weights Initial weights for the neuron
  * @param float $learningRate The learning rate
  * @return Neuron The new neuron (instance of a Neuron child class)
  */
  public abstract function createNeuron(array $weights, float $learningRate): Neuron;

  /**
  * Derivation of the activation function to adjust the weights
  *
  * Has to be overridden by child classes to choose a specific function
  *
  * @param float $x Value to apply the derivative activation function to
  * @return float Result of this calculation
  */
  public abstract function derivativeActivationFunction(float $x): float;
}
