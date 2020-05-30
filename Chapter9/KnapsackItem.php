<?php

class KnapsackItem {
  private $name = '';
  private $weight = 0;
  private $value = 0.0;

  public function __construct(string $name, int $weight, float $value) {
    $this->name = $name;
    $this->weight = $weight;
    $this->value = $value;
  }

  public function __get($property) {
    switch ($property) {
    case 'name':
      return $this->name;
    case 'weight':
      return $this->weight;
    case 'value':
      return $this->value;
    }
  }
}
