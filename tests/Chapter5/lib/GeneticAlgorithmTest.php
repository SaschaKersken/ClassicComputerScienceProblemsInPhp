<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class GeneticAlgorithmTest extends TestCase {
  /**
  * @covers GeneticAlgorithm::__construct
  */
  public function testConstruct() {
    $ga = new GeneticAlgorithm([], 1);
    $this->assertInstanceOf('GeneticAlgorithm', $ga);
  }

  /**
  * @covers GeneticAlgorithm::choices
  * @dataProvider choicesProvider
  */
  public function testChoices($weights) {
    $ga = new GeneticAlgorithm([], 1);
    $choices = $ga->choices([1, 2, 3], $weights, 2);
    $this->assertEquals(2, count($choices));
  }

  public function choicesProvider() {
    return [
      [[0.5, 1, 1]],
      [NULL]
    ];
  }

  /**
  * @covers GeneticAlgorithm::pickRoulette
  */
  public function testPickRoulette() {
    $ga = new GeneticAlgorithm(
      [
        DummyChromosome::randomInstance(),
        DummyChromosome::randomInstance(),
        DummyChromosome::randomInstance(),
        DummyChromosome::randomInstance()
      ],
      1
    );
    $this->assertEquals(2, count($ga->pickRoulette([1, 0.5, 0.25, 0.125])));
  }

  /**
  * @covers GeneticAlgorithm::pickTournament
  */
  public function testPickTournament() {
    $ga = new GeneticAlgorithm(
      [
        DummyChromosome::randomInstance(),
        DummyChromosome::randomInstance(),
        DummyChromosome::randomInstance(),
        DummyChromosome::randomInstance()
      ],
      1
    );
    $this->assertEquals(2, count($ga->pickTournament(4)));
  }

  /**
  * @covers GeneticAlgorithm::reproduceAndReplace
  * @dataProvider reproduceAndReplaceProvider
  */
  public function testReproduceAndReplace($selectionType, $crossoverChance) {
    $population = [];
    for ($i = 0; $i < 10; $i++) {
      $population[] = DummyChromosome::randomInstance();
    }
    $ga = new GeneticAlgorithm(
      $population,
      1,
      10,
      1,
      $crossoverChance,
      $selectionType
    );
    $ga->reproduceAndReplace();
    $this->assertEquals(2, count($ga->pickTournament(10)));
  }

  public function reproduceAndReplaceProvider() {
    return [
      [SelectionType::ROULETTE, 1],
      [SelectionType::TOURNAMENT, 0]
    ];
  }
}

class DummyChromosome extends Chromosome {
  public function fitness(): float {
    return 1;
  }

  public static function randomInstance(): Chromosome {
    return new DummyChromosome();
  }

  public function crossover(Chromosome $other): array {
    return [$this, $other];
  }

  public function mutate() {
    // Nothing to do here
  }
}
