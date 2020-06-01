<?php

require_once(__DIR__.'/../Util.php');

/**
* Knapsack class
*
* Implementation of the knapsack problem using dynamic programming
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Knapsack {
  /**
  * Available items
  * @var array of KnapsackItem elements
  */
  private $items = [];

  /**
  * Constructor
  *
  * @param array $items Available items
  */
  public function __construct(array $items) {
    $this->items = $items;
  }

  /**
  * Run the algorithm
  *
  * @param int $maxCapacity Maximum capacity of the knapsack to use
  * @return array Optimal set of items to put into knapsack
  */
  public function run(int $maxCapacity): array {
    // Build up dynamic programming table
    $table = array_fill(
      0,
      count($this->items),
      array_fill(
        0,
        $maxCapacity + 1,
        0.0
      )
    );
    foreach ($this->items as $i => $item) {
      for ($capacity = 1; $capacity <= $maxCapacity; $capacity++) {
        $previousItemsValue = $table[$i][$capacity];
        if ($capacity >= $item->weight) { // item fits in knapsack
          $valueFreeingWeightForItem = $table[$i][$capacity - $item->weight];
          // only take if more valuable than previous item
          $table[$i + 1][$capacity] = max(
            $valueFreeingWeightForItem + $item->value,
            $previousItemsValue
          );
        } else { // no room for this item
          $table[$i + 1][$capacity] = $previousItemsValue;
        }
      }
    }
    // figure out solution from table
    $solution = [];
    $capacity = $maxCapacity;
    for ($i = count($this->items); $i > 0; $i--) { // work backwards
      // was this item used?
      if ($table[$i - 1][$capacity] != $table[$i][$capacity]) {
        $solution[] = $this->items[$i - 1];
        // if the item was used, remove its weight
        $capacity -= $this->items[$i - 1]->weight;
      }
    }
    return $solution;
  }

  /**
  * Set a different list of available items
  *
  * @param array $items The new list of items
  */
  public function setItems(array $items) {
    $this->items = $items;
  }
}
