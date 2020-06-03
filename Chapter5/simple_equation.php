<?php

require_once(__DIR__.'/../Util.php');

$initialPopulation = [];
for ($i = 0; $i < 20; $i++) {
  $initialPopulation[] = SimpleEquation::randomInstance();
}
$ga = new GeneticAlgorithm($initialPopulation, 13.0, 100, 0.1, 0.7);
$result = $ga->run();
Util::out($result);
