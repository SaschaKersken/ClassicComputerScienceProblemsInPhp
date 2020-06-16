<?php

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

  /**
  * @covers WordSearchConstraint::unique
  */
  public function testUnique() {
    $wordSearchConstraint = new WordSearchConstraint_TestProxy(['W1', 'W2']);
    $this->assertEquals(
      [['A', 'B'], ['C', 'D']],
      $wordSearchConstraint->unique([['A', 'B'], ['C', 'D'], ['A', 'B']])
    );
  }
}

class WordSearchConstraint_TestProxy extends WordSearchConstraint {
  public function unique(array $array): array {
    return parent::unique($array);
  }
}
