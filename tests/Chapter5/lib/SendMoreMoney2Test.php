<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class SendMoreMoney2Test extends TestCase {
  /**
  * @covers SendMoreMoney2::__construct
  */
  public function testConstruct() {
    $send = new SendMoreMoney2([]);
    $this->assertInstanceOf('SendMoreMoney2', $send);
  }

  /**
  * @covers SendMoreMoney2::fitness
  */
  public function testFitness() {
    $send = new SendMoreMoney2(['S', 'E', 'N', 'D', 'M', 'O', 'R', 'Y']);
    $this->assertEqualsWithDelta(0.00002, $send->fitness(), 0.00001);
  }

  /**
  * @covers SendMoreMoney2::randomInstance
  */
  public function testRandomInstance() {
    $this->assertInstanceOf(
      'SendMoreMoney2',
      SendMoreMoney2::randomInstance()
    );
  }

  /**
  * @covers SendMoreMoney2::crossover
  */
  public function testCrossover() {
    $send = SendMoreMoney2::randomInstance();
    $this->assertEquals(2, count($send->crossover(SendMoreMoney2::randomInstance())));
  }

  /**
  * @covers SendMoreMoney2::mutate
  */
  public function testMutate() {
    $send = SendMoreMoney2::randomInstance();
    $send->mutate();
    $this->assertIsFloat($send->fitness());
  }

  /**
  * @covers SendMoreMoney2::__toString
  */
  public function testToString() {
    $send = SendMoreMoney2::randomInstance();
    $this->assertMatchesRegularExpression(
      '(^\d+ \+ \d+ = \d+; Difference: \d+$)',
      $send->__toString()
    );
  }
}
