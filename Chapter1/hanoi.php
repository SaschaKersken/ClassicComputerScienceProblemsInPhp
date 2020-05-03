<?php

require_once(__DIR__.'/../Output.php');

class Stack {
  private $_container = [];

  public function push($item) {
    $this->_container[] = $item;
  }

  public function pop() {
    return array_pop($this->_container);
  }

  public function __toString() {
    return implode(', ', $this->_container);
  }
}

class Hanoi {
  private $numDiscs = 3;
  private $towerA;
  private $towerB;
  private $towerC;

  public function __construct() {
    $this->towerA = new Stack();
    $this->towerB = new Stack();
    $this->towerC = new Stack();
    for ($i = 1; $i <= $this->numDiscs; $i++) {
       $this->towerA->push($i);
    }
  }

  public function run() {
    Output::out("Before:");
    $this->printTowers();
    $this->hanoi($this->towerA, $this->towerC, $this->towerB, $this->numDiscs);
    Output::out("After:");
    $this->printTowers();
  }

  public function hanoi(Stack $begin, Stack $end, Stack $temp, int $n) {
    if ($n == 1) {
      $end->push($begin->pop());
    } else {
      $this->hanoi($begin, $temp, $end, $n - 1);
      $this->hanoi($begin, $end, $temp, 1);
      $this->hanoi($temp, $end, $begin, $n - 1);
    }
  }

  private function printTowers() {
    Output::out('A: '.$this->towerA);
    Output::out('B: '.$this->towerB);
    Output::out('C: '.$this->towerC);
  }
}

$hanoi = new Hanoi();
$hanoi->run();
