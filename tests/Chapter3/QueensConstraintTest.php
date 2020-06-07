<?php

require_once(__DIR__.'/../../Util.php');

use PHPUnit\Framework\TestCase;

final class QueensConstraintTest extends TestCase {
  /**
  * @covers QueensContraint::__construct
  */
  public function testConstruct() {
    $queensConstraint = new QueensConstraint([0, 1]);
    $this->assertInstanceOf('QueensConstraint', $queensConstraint);
  }

  /**
  * @covers QueensConstraint::satisfied
  * @dataProvider satisfiedProvider
  */
  public function satisfiedTest($q1, $q2, $expected) {
    $queensConstraint = new QueensConstraint([0, 1]);
    $assignment = [$q1];
    if (!is_null($q2)) {
      $assignment[] = $q2;
    }
    $this->assertEquals(
      $expected,
      $queensConstraint->satisfied($assignment)
    );
  }

  public function satisfiedProvider() {
    return [
      [0, NULL, TRUE],
      [0, 0, FALSE],
      [0, 1, FALSE],
      [0, 2, TRUE]
    ];
  }
}
