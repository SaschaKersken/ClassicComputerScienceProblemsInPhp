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
  * @covers SimpleEquation::__toString
  */
  public function testToString() {
    $equation = new SimpleEquation(3, 2);
    $this->assertEquals('X: 3, Y: 2, Fitness: 13.00', $equation->__toString());
  }
}
