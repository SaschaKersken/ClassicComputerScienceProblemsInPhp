<?php

require_once(__DIR__.'/../../../Chapter3/lib/Constraint.php');

use PHPUnit\Framework\TestCase;

final class CSPTest extends TestCase {
  /**
  * @covers CSP::__construct
  */
  public function testConstruct() {
    $csp = new CSP(['A', 'B'], ['A' => [1, 2], 'B' => [1, 2]]);
    $this->assertInstanceOf('CSP', $csp);
  }

  /**
  * @covers CSP::__construct
  */
  public function testConstructExpectingException() {
    try {
      $csp = new CSP(['A', 'B'], []);
      $this->fail('Excpected InvalidArgumentException not thrown.');
    } catch (InvalidArgumentException $e) {
      $this->assertEquals(
        'Every variable should have a domain assigned to it.',
        $e->getMessage()
      );
    }
  }

  /**
  * @covers CSP::addConstraint
  */
  public function testAddConstraint() {
    $csp = new CSP(['A', 'B'], ['A' => [1, 2], 'B' => [1, 2]]);
    $csp->addConstraint(new DummyConstraint('A', 'B'));
    $this->assertTrue($csp->consistent('A', ['A' => 1]));
  } 

  /**
  * @covers CSP::addConstraint
  */
  public function testAddConstraintExpectingException() {
    $csp = new CSP(['A', 'B'], ['A' => [1, 2], 'B' => [1, 2]]);
    try {
      $csp->addConstraint(new DummyConstraint('A', 'C'));
      $this->fail('Expected InvalidArgumentException not thrown.');
    } catch(InvalidArgumentException $e) {
      $this->assertEquals(
        'Variable in constraint not in CSP.',
        $e->getMessage()
      );
    }
  }

  /**
  * @covers CSP::consistent
  * @dataProvider consistentProvider
  */
  public function testConsistent($a, $b, $expected) {
    $csp = new CSP(['A', 'B'], ['A' => [1, 2], 'B' => [1, 2]]);
    $csp->addConstraint(new DummyConstraint('A', 'B'));
    $this->assertEquals(
      $expected,
      $csp->consistent('A', ['A' => $a, 'B' => $b])
    );
  }

  public function consistentProvider() {
    return [
      [1, 1, FALSE],
      [1, 2, TRUE]
    ];
  }

  /**
  * @covers CSP::backtrackingSearch
  */
  public function testBacktrackingSearch() {
    $csp = new CSP(['A', 'B'], ['A' => [1, 2], 'B' => [1, 2]]);
    $csp->addConstraint(new DummyConstraint('A', 'B'));
    $this->assertEquals(
      ['A' => 1, 'B' => 2],
      $csp->backtrackingSearch()
    );
  }
}

class DummyConstraint extends Constraint {
  private $a = NULL;
  private $b = NULL;

  public function __construct($a, $b) {
    parent::__construct([$a, $b]);
    $this->a = $a;
    $this->b = $b;
  }

  public function satisfied($assignment): bool {
    if (!array_key_exists($this->a, $assignment) ||
        !array_key_exists($this->b, $assignment)) {
      return TRUE;
    }
    return $assignment[$this->a] != $assignment[$this->b];
  }
}
