<?php

/**
* Tower of Hanoi class
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Hanoi {
  /**
  * Number of discs (hardcoded to 3 for this example)
  * @var int
  */
  private $numDiscs = 3;

  /**
  * First tower
  * @var Stack
  */
  private $towerA;

  /**
  * Second tower
  * @var Stack
  */
  private $towerB;

  /**
  * Third tower
  * @var Stack
  */
  private $towerC;

  /**
  * Constructor
  */
  public function __construct() {
    $this->towerA = new Stack();
    $this->towerB = new Stack();
    $this->towerC = new Stack();
    for ($i = 1; $i <= $this->numDiscs; $i++) {
       $this->towerA->push($i);
    }
  }

  /**
  * Recursively solve the Towers
  *
  * @param Stack $begin Tower to take discs from
  * @param Stack $end Tower to move discs to
  * @param Stack $temp Temporary helper tower
  * @param int $n Number of discs left to move
  */
  public function hanoi(Stack $begin, Stack $end, Stack $temp, int $n) {
    if ($n == 1) {
      $end->push($begin->pop());
    } else {
      $this->hanoi($begin, $temp, $end, $n - 1);
      $this->hanoi($begin, $end, $temp, 1);
      $this->hanoi($temp, $end, $begin, $n - 1);
    }
  }

  /**
  * Pretty-print the towers
  */
  private function printTowers() {
    Util::out('A: '.$this->towerA);
    Util::out('B: '.$this->towerB);
    Util::out('C: '.$this->towerC);
  }

  /**
  * Run the algorithm
  */
  public function run() {
    Util::out("Before:");
    $this->printTowers();
    $this->hanoi($this->towerA, $this->towerC, $this->towerB, $this->numDiscs);
    Util::out("After:");
    $this->printTowers();
  }
}
