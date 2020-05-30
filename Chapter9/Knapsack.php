<?php

require_once(__DIR__.'/KnapsackItem.php');

class Knapsack {
  private $items = [];
  private $maxCapacity = 0;

  public function __construct(array $items, int $maxCapacity) {
    $this->items = $items;
    $this->maxCapacity = $maxCapacity;
  }

  public function run(): array {
    // Build up dynamic programming table
    $table = array_fill(
      0,
      count($this->items),
      array_fill(
        0,
        $this->maxCapacity + 1,
        0.0
      )
    );
    foreach ($this->items as $i => $item) {
      for ($capacity = 1; $capacity <= $this->maxCapacity; $capacity++) {
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
    $capacity = $this->maxCapacity;
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
}
