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
}
