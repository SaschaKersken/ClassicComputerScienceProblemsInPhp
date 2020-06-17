<?php

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

  /**
  * @covers GeneticAlgorithm::mutate
  */
  public function testMutate() {
    $chromosome = DummyChromosome::randomInstance();
    $ga = new GeneticAlgorithm([$chromosome], 1, 1, 1);
    $ga->mutate();
    $this->assertTrue($chromosome->mutated);
  }

  /**
  * @covers GeneticAlgorithm::_bestAndAvgByFitness
  */
  public function testBestAndAvgByFitness() {
    $chromosomes = [
      new DummyChromosome(1),
      new DummyChromosome(2),
      new DummyChromosome(2),
      new DummyChromosome(3)
    ];
    $ga = new GeneticAlgorithm_TestProxy($chromosomes, 1, 2);
    $this->assertEquals([$chromosomes[3], 2], $ga->_bestAndAvgByFitness());
  }

  /**
  * @covers GeneticAlgorithm::run
  * @dataProvider runProvider
  */
  public function testRun($threshold) {
    $this->setOutputCallback(function() {});
    $chromosomes = [
      DummyChromosome::randomInstance(),
      DummyChromosome::randomInstance(),
      DummyChromosome::randomInstance(),
      DummyChromosome::randomInstance()
    ];
    $ga = new GeneticAlgorithm($chromosomes, $threshold, 2);
    $this->assertSame($chromosomes[0], $ga->run());
  }

  public function runProvider() {
    return [
      [1],
      [2]
    ];
  }

  /**
  * @covers GeneticAlgorithm::randomizer
  */
  public function testRandomizerSet() {
    $randomizer = $this
      ->getMockBuilder('Randomizer')
      ->getMock();
    $ga = new GeneticAlgorithm([], 1, 2);
    $this->assertSame($randomizer, $ga->randomizer($randomizer));
  }

  /**
  * @covers GeneticAlgorithm::randomizer
  */
  public function testRandomizerInit() {
    $ga = new GeneticAlgorithm([], 1, 2);
    $this->assertInstanceOf('Randomizer', $ga->randomizer());
  }
}

class DummyChromosome extends Chromosome {
  public $mutated = FALSE;

  private $fitness = 1;

  public function __construct(int $fitness = 1) {
    $this->fitness = $fitness;
  }

  public function fitness(): float {
    return $this->fitness;
  }

  public static function randomInstance(): Chromosome {
    return new DummyChromosome();
  }

  public function crossover(Chromosome $other): array {
    return [$this, $other];
  }

  public function mutate() {
    $this->mutated = TRUE;
  }
}

class GeneticAlgorithm_TestProxy extends GeneticAlgorithm {
  public function _bestAndAvgByFitness(): array {
    return parent::_bestAndAvgByFitness();
  }
}
