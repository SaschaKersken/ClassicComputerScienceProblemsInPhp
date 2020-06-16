<?php

require_once(__DIR__.'/../Autoloader.php');

$initialPopulation = [];
for ($i = 0; $i < 100; $i++) {
  $initialPopulation[] = ListCompression::randomInstance();
}
$ga = new GeneticAlgorithm($initialPopulation, 1.0, 100, 0.2, 0.7, SelectionType::TOURNAMENT);
$result = $ga->run();
Util::out($result);
