<?php

require_once(__DIR__.'/../Autoloader.php');

$items = [
  new KnapsackItem("television", 50, 500),
  new KnapsackItem("candlesticks", 2, 300),
  new KnapsackItem("stereo", 35, 400),
  new KnapsackItem("laptop", 3, 1000),
  new KnapsackItem("food", 15, 50),
  new KnapsackItem("clothing", 20, 800),
  new KnapsackItem("jewelry", 1, 4000),
  new KnapsackItem("books", 100, 300),
  new KnapsackItem("printer", 18, 30),
  new KnapsackItem("refrigerator", 200, 700),
  new KnapsackItem("painting", 10, 1000)
];
$knapsack = new Knapsack($items);
$result = $knapsack->run(75);
foreach ($result as $item) {
  Util::out(
    sprintf("%s (weight %d, value %d)", $item->name, $item->weight, $item->value)
  );
}
