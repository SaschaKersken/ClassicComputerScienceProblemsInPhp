<?php

/**
* Knapsack item class
*
* Represents an item to be put into the knapsack
*
* @package ClassicComputerScienceProblemsInPhp
*
* @property string $name Name of this item
* @property int $weight Weight of this item
* @property float $value Value of this item
*/
class KnapsackItem {
  /**
  * Name of this item
  * @var string $name
  */
  private $name = '';

  /**
  * Weight of this item
  * @var int $weight
  */
  private $weight = 0;

  /**
  * Value of this item
  * @var float $value
  */
  private $value = 0.0;

  /**
  * Constructor
  *
  * @param string $name Name of new item
  * @param int $weight Weight of new item
  * @param float $value Value of new item
  */
  public function __construct(string $name, int $weight, float $value) {
    $this->name = $name;
    $this->weight = $weight;
    $this->value = $value;
  }

  /**
  * Magic getter method
  *
  * @param string $property The property to read
  * @return mixed value of the property
  */
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
