<?php

require_once(__DIR__.'/../../Util.php');

use PHPUnit\Framework\TestCase;

final class WordSearchConstraintTest extends TestCase {
  /**
  * @covers WordSearchConstraint::__construct
  */
  public function testConstruct() {
    $wordSearchConstraint = new WordSearchConstraint(['W1', 'W2']);
    $this->assertInstanceOf('WordSearchConstraint', $wordSearchConstraint);
  }

  /**
  * @covers WordSearchConstraint::satisfied
  * @dataProvider satisfiedProvider
  */
  public function testSatisfied($w1, $w2, $expected) {
    $wordSearchConstraint = new WordSearchConstraint(['W1', 'W2']);
    $assignment = [$w1];
    if (!is_null($w2)) {
      $assignment[] = $w2;
    }
    $this->assertEquals(
      $expected,
      $wordSearchConstraint->satisfied($assignment)
    );
  }

  public function satisfiedProvider() {
    return [
      [[[0, 0], [0, 1]], NULL, TRUE],
      [[[0, 0], [0, 1]], [[0, 1], [1, 1]], FALSE],
      [[[0, 0], [0, 1]], [[1, 0], [1, 1]], TRUE]
    ];
  }
}
