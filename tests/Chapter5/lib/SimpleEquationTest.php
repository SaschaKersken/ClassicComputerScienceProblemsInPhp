<?php
  
require_once(__DIR__.'/../../../Util.php');

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
    $equation = new SimpleEquation_TestProxy(23, 42, [$random1, $random2]);
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
  * @covers SimpleEquation::randomFloat
  */
  public function testRandomFloat() {
    $equation = new SimpleEquation_TestProxy(23, 42);
    $rand = $equation->randomFloat();
    $this->assertGreaterThanOrEqual(0, $rand);
    $this->assertLessThanOrEqual(1, $rand);
  }
}

class SimpleEquation_TestProxy extends SimpleEquation {
  private $randomQueue = [];

  public function __construct(int $x, int $y, array $randomQueue = []) {
    parent::__construct($x, $y);
    $this->randomQueue = $randomQueue;
  }

  public function randomFloat(): float {
    $result = array_shift($this->randomQueue);
    if (is_null($result)) {
      $result = parent::randomFloat();
    }
    return $result;
  }
}
