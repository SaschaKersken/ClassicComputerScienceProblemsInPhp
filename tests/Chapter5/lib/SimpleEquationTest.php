<?php

use PHPUnit\Framework\TestCase;

final class SimpleEquationTest extends TestCase {
  /**
  * @covers SimpleEquation::__construct
  */
  public function testConstruct() {
    $equation = new SimpleEquation(2, 3);
    $this->assertInstanceOf('SimpleEquation', $equation);
  }

  /**
  * @covers SimpleEquation::fitness
  */
  public function testFitness() {
    $equation = new SimpleEquation(3, 2);
    $this->assertEquals(13, $equation->fitness());
  }

  /**
  * @covers SimpleEquation::randomInstance
  */
  public function testRandomInstance() {
    $this->assertInstanceOf('SimpleEquation', SimpleEquation::randomInstance());
  }

  /**
  * @covers SimpleEquation::crossover
  */
  public function testCrossover() {
    $equation1 = new SimpleEquation(1, 42);
    $equation2 = new SimpleEquation(2, 23);
    $result = $equation1->crossover($equation2);
    $this->assertMatchesRegularExpression('(Y: 23)', $result[0]->__toString());
    $this->assertMatchesRegularExpression('(Y: 42)', $result[1]->__toString());
  }

  /**
  * @covers SimpleEquation::mutate
  * @dataProvider mutateProvider
  */
  public function testMutate($random1, $random2, $expected) {
    $randomizer = $this
      ->getMockBuilder('Randomizer')
      ->getMock();
    $randomizer
      ->expects($this->exactly(2))
      ->method('randomFloat')
      ->will($this->onConsecutiveCalls($random1, $random2));
    $equation = new SimpleEquation(23, 42);
    $equation->randomizer($randomizer);
    $equation->mutate();
    $this->assertEquals($expected, [$equation->x, $equation->y]);
  }

  public function mutateProvider() {
    return [
      [0.7, 0.7, [24, 42]],
      [0.7, 0.2, [22, 42]],
      [0.2, 0.7, [23, 43]],
      [0.2, 0.2, [23, 41]]
    ];
  }

  /**
  * @covers SimpleEquation::__toString
  */
  public function testToString() {
    $equation = new SimpleEquation(3, 2);
    $this->assertEquals('X: 3, Y: 2, Fitness: 13.00', $equation->__toString());
  }

  /**
  * @covers SimpleEquation::randomizer
  */
  public function testRandomizerSet() {
    $randomizer = $this
      ->getMockBuilder('Randomizer')
      ->getMock();
    $equation = new SimpleEquation(23, 42);
    $this->assertSame($randomizer, $equation->randomizer($randomizer));
  }

  /**
  * @covers SimpleEquation::randomizer
  */
  public function testRandomizerInit() {
    $equation = new SimpleEquation(23, 42);
    $this->assertInstanceOf('Randomizer', $equation->randomizer());
  }
}
