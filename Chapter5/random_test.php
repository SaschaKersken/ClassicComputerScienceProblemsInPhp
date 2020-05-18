<?php

require_once(__DIR__.'/GeneticAlgorithm.php');

class CTest {
  private $f = 0;

  public function __construct(int $f) {
    $this->f = $f;
  }

  public function fitness() {
    return $this->f;
  }
}

$pop = [];
$wheel = [];
for ($i = 0; $i < 100; $i++) {
  $pop[] = new CTest($i);
  $wheel[] = 100 - $i;
}

$ga = new GeneticAlgorithm($pop, 10);

echo "Wheel:\n";
var_dump($ga->pickRoulette($wheel));
echo "Tournament (10):\n";
var_dump($ga->pickTournament(10));
