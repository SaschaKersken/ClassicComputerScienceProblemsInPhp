<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class MapColoringConstraintTest extends TestCase {
  /**
  * @covers MapColoringConstraint::__construct
  */
  public function testConstruct() {
    $mapColoringConstraint = new MapColoringConstraint('Place 1', 'Place 2');
    $this->assertInstanceOf('MapColoringConstraint', $mapColoringConstraint);
  }

  /**
  * @cover MapColoringConstraint::satisfied
  * @dataProvider satisfiedProvider
  */
  public function testSatisfied($color1, $color2, $expected) {
    $mapColoringConstraint = new MapColoringConstraint('Place 1', 'Place 2');
    $assignment = ['Place 1' => $color1];
    if ($color2) {
      $assignment['Place 2'] = $color2;
    }
    $this->assertEquals(
      $expected,
      $mapColoringConstraint->satisfied($assignment)
    );
  }

  public function satisfiedProvider() {
    return [
      ['red', NULL, TRUE],
      ['red', 'green', TRUE],
      ['red', 'red', FALSE]
    ];
  }
}
