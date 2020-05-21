<?php

class DataPoint {
  private $_originals = [];
  public $dimensions = [];

  public function __construct(array $initial) {
    $this->_originals = $initial;
    $this->dimensions = $initial;
  }

  public function __get($property) {
    if ($property == 'numDimensions') {
      return count($this->dimensions);
    }
  }

  public function distance(DataPoint $other): float {
    $combined = array_map(NULL, $this->dimensions, $other->dimensions);
    $differences = array_map(
      function($e) {
        return ($e[0] - $e[1]) ** 2;
      },
      $combined
    );
    return sqrt(array_sum($differences));
  }

  public function __toString(): string {
    return implode(', ', $this->_originals);
  }
}
