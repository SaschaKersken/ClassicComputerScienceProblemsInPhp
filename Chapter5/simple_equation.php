<?php

require_once(__DIR__.'/GeneticAlgorithm.php');
require_once(__DIR__.'/../Util.php');

class SimpleEquation extends Chromosome {
  private $x = 0;
  private $y = 0;

  public function __construct(int $x, int $y) {
    $this->x = $x;
    $this->y = $y;
  }

  public function fitness(): float {
    return 6 * $this->x - $this->x * $this->x + 4 * $this->y - $this->y * $this->y;
  }

  public static function randomInstance() {
    return new SimpleEquation(rand(0, 100), rand(0, 100));
  }

  public function crossover($other): array {
    $child1 = clone $this;
    $child2 = clone $other;
    $child1->y = $other->y;
    $child2->y = $this->y;
    return [$child1, $child2];
  }

  public function mutate() {
    $mutateX = (float)rand() / getrandmax();
    if ($mutateX > 0.5) {
      $this->x++;
    } else {
      $this->x--;
    }
    $mutateY = (float)rand() / getrandmax();
    if ($mutateY > 0.5) {
      $this->y++;
    } else {
      $this->y--;
    }
  }

  public function __toString(): string {
    return sprintf("X: %d, Y: %d, Fitness: %f", $this->x, $this->y, $this->fitness());
  }
}

$initialPopulation = [];
for ($i = 0; $i < 20; $i++) {
  $initialPopulation[] = SimpleEquation::randomInstance();
}
$ga = new GeneticAlgorithm($initialPopulation, 13.0, 100, 0.1, 0.7);
$result = $ga->run();
Util::out($result);
