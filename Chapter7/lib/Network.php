<?php

require_once(__DIR__.'/../../Util.php');

/**
* Network class
*
* Artificial neural network
*
* @package ClassicComputerScienceProblemsInPhp
*/
abstract class Network {
  /**
  * The network's layers
  * @var array
  */
  private $layers = [];

  /**
  * Constructor
  *
  * @param array $layerStructure Number of neurons in each layer
  * @param float $learningRate Learning rate for the layers/neurons
  * @throws InvalidArgumentException if there are less than 3 layers
  */
  public function __construct(array $layerStructure, float $learningRate) {
    if (count($layerStructure) < 3) {
      throw new InvalidArgumentException(
        "Error: Should be at least 3 layers (1 input, 1 hidden, 1 output)"
      );
    }
    // Input layer
    $inputLayer = $this->createLayer(NULL, $layerStructure[0], $learningRate);
    $this->layers[] = $inputLayer;
    // Hidden layers and output layer
    foreach (array_slice($layerStructure, 1) as $previous => $numNeurons) {
      $nextLayer = $this->createLayer(
        $this->layers[$previous],
        $numNeurons,
        $learningRate
      );
      $this->layers[] = $nextLayer;
    }
  }

  /**
  * Generate output from all layers in a row
  *
  * Pushes input data to the first layer, then output from the first
  * as input to the second, second to the third, etc.
  *
  * @param array $input Input data
  * @return array Final output
  */
  public function outputs(array $input): array {
    return array_reduce(
      $this->layers,
      function ($inputs, $layer) {
        return $layer->outputs($inputs);
      },
      $input
    );
  }

  /**
  * Perform backpropagation
  *
  * Figure out each neuron's changes based on the errors of the output
  * versus the expected outcome
  *
  * @param array $expected Expected output values
  */
  public function backpropagate(array $expected) {
    $lastLayer = count($this->layers) - 1;
    $this->layers[$lastLayer]->calculateDeltasForOutputLayer($expected);
    // Calculate delta for hidden layers in reverse order
    for ($l = $lastLayer - 1; $l > 0; $l--) {
      $this->layers[$l]->calculateDeltasForHiddenLayer($this->layers[$l + 1]);
    }
  }

  /**
  * Update the weights based on deltas
  *
  * backpropagate() doesn't actually change any weights
  * this function uses the deltas calculated in backpropagate() to
  * actually make changes to the weights
  */
  public function updateWeights() {
    foreach (array_slice($this->layers, 1) as $layer) { // skip input layer
      foreach ($layer->neurons as $neuron) {
        for ($w = 0; $w < count($neuron->weights); $w++) {
          $neuron->weights[$w] += 
            $neuron->learningRate * $layer->previousLayer->outputCache[$w] *
            $neuron->delta;
        }
      }
    }
  }

  /**
  * Perform training
  *
  * train() uses the results of outputs() run over many inputs and compared
  * against expecteds to feed backpropagate() and update_weights()
  *
  * @param array $inputs Input values
  * @param array $expecteds Expected output values
  */
  public function train(array $inputs, array $expecteds) {
    foreach ($inputs as $location => $xs) {
      $ys = $expecteds[$location];
      $outs = $this->outputs($xs);
      $this->backpropagate($ys);
      $this->updateWeights();
    }
  }

  /**
  * Validate classification success
  *
  * For generalized results that require classification this function will return
  * the correct number of trials and the percentage correct out of the total
  *
  * @param array $inputs Input values
  * @param array $expecteds Expected output values
  * @param callable $interpreteOutput Function to generate human-readable output
  * @return array number of correct classifications, number of inputs, percentage
  */
  public function validate(array $inputs, array $expecteds,
      callable $interpretOutput): array {
    $correct = 0;
    for ($i = 0; $i < count($inputs); $i++) {
      $input = $inputs[$i];
      $expected = $expecteds[$i];
      $result = $interpretOutput($this->outputs($input));
      if ($result == $expected) {
        $correct++;
      }
    }
    $percentage = (float)$correct / count($inputs);
    return [$correct, count($inputs), $percentage];
  }

  /**
  * Create a layer
  *
  * Needs to be overridden by child classes to create a specific type of Layer
  *
  * @param mixed $previousLayer The previous layer (Layer) or NULL if input layer
  * @param int $numNeurons Number of neurons in the layer
  * @param float $learningRate Learning rate for the neurons
  * @return Layer The new layer
  */
  public abstract function createLayer($previousLayer, int $numNeurons,
    float $learningRate): Layer;
}
