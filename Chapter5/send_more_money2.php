<?php

require_once(__DIR__.'/../Util.php');

$initialPopulation = [];
for ($i = 0; $i < 1000; $i++) {
  $initialPopulation[] = SendMoreMoney2::randomInstance();
}
$ga = new GeneticAlgorithm(
  $initialPopulation,
  1.0,
  1000,
  0.2,
  0.7,
  SelectionType::ROULETTE
);
$result = $ga->run();
Util::out($result);
