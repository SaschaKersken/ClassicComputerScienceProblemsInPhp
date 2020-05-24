<?php

require_once(__DIR__.'/NetworkUtils.php');

abstract class Neuron {
  public $weights = [];
  public $outputCache = 0.0;
  public $delta = 0.0;
  public $learningRate = 0.0;

  public function __construct(array $weights, float $learningRate) {
    $this->weights = $weights;
    $this->learningRate = $learningRate;
    $this->outputCache = 0.0;
    $this->delta = 0.0;
  }

  public function output(array $inputs) {
    $this->outputCache = NetworkUtils::dotProduct($inputs, $this->weights);
    return $this->activationFunction($this->outputCache);
  }

  public abstract function activationFunction(float $x): float;
}
