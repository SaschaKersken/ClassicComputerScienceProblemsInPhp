<?php

use PHPUnit\Framework\TestCase;

final class ConstraintTest extends TestCase {
  /**
  * @covers Constraint::__construct
  */
  public function testConstruct() {
    $constraint = new Constraint_TestProxy([]);
    $this->assertInstanceOf('Constraint', $constraint);
  }
}

class Constraint_TestProxy extends Constraint {
  public function satisfied(array $assignment): bool {
    return FALSE;
  }
}
