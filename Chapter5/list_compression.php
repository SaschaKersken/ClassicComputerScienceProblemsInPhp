<?php

require_once(__DIR__.'/GeneticAlgorithm.php');
require_once(__DIR__.'/../Output.php');

class ListCompression extends Chromosome {
  const PEOPLE = ["Michael", "Sarah", "Joshua", "Narine", "David", "Sajid", "Melanie", "Daniel", "Wei", "Dean", "Brian", "Murat", "Lisa"];
  public $list = [];

  public function __construct(array $list) {
    $this->list = $list;
  }

  public function __get($property) {
    switch ($property) {
    case 'bytesCompressed':
      return strlen(zlib_encode(implode(':', $this->list), ZLIB_ENCODING_DEFLATE));
    }
  }

  public function fitness(): float {
    return 1 / $this->bytesCompressed;
  }

  public static function randomInstance() {
    $myList = self::PEOPLE;
    shuffle($myList);
    return new ListCompression($myList);
  }

  public function crossover($other): array {
    $child1 = clone $this;
    $child2 = clone $other;
    $idx1 = rand(0, count($this->list) - 1);
    $idx2 = rand(0, count($this->list) - 1);
    $l1 = $child1->list[$idx1];
    $l2 = $child2->list[$idx2];
    $child1->list[array_search($l2, $child1->list)] = $child1->list[$idx2];
    $child1->list[$idx2] = $l2;
    $child2->list[array_search($l1, $child2->list)] = $child2->list[$idx1];
    $child2->list[$idx1] = $l1;
    return [$child1, $child2];
  }

  public function mutate() {
    $idx1 = rand(0, count($this->list) - 1);
    $idx2 = rand(0, count($this->list) - 1);
    $helper = $this->list[$idx1];
    $this->list[$idx1] = $this->list[$idx2];
    $this->list[$idx2] = $helper;
  }

  public function __toString(): string {
    return sprintf("Order: %s; Bytes: %d", implode(', ', $this->list), $this->bytesCompressed);
  }
}

$initialPopulation = [];
for ($i = 0; $i < 100; $i++) {
  $initialPopulation[] = ListCompression::randomInstance();
}
$ga = new GeneticAlgorithm($initialPopulation, 1.0, 100, 0.2, 0.7, SelectionType::TOURNAMENT);
$result = $ga->run();
Output::out($result);
