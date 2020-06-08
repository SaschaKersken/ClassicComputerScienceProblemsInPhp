<?php

require_once(__DIR__.'/../../Util.php');

/**
* SendMoreMoney2 class
*
* Solve the cryptarithmetic puzzle SEND+MORE=MONEY
* using genetic algorithms
*
* @package ClassicComputerScienceProblemsInPhp
*/
class SendMoreMoney2 extends Chromosome {
  /**
  * Current chromosome's letter assignment
  */
  public $letters = [];

  /**
  * Constructor
  * @param array $letters Letter assignment
  */
  public function __construct(array $letters) {
    $this->letters = $letters;
  }

  /**
  * Calculate fitness
  *
  * @return float
  */
  public function fitness(): float {
    $s = array_search('S', $this->letters);
    $e = array_search('E', $this->letters);
    $n = array_search('N', $this->letters);
    $d = array_search('D', $this->letters);
    $m = array_search('M', $this->letters);
    $o = array_search('O', $this->letters);
    $r = array_search('R', $this->letters);
    $y = array_search('Y', $this->letters);
    $send = $s * 1000 + $e * 100 + $n * 10 + $d;
    $more = $m * 1000 + $o * 100 + $r * 10 + $e;
    $money = $m * 10000 + $o * 1000 + $n * 100 + $e * 10 + $y;
    $difference = abs($money - ($send + $more));
    return 1 / ($difference + 1);
  }

  /**
  * Get a random instance
  *
  * @return Chromosome The random instance
  */
  public static function randomInstance(): Chromosome {
    $letters = ['S', 'E', 'N', 'D', 'M', 'O', 'R', 'Y', '', ''];
    shuffle($letters);
    return new SendMoreMoney2($letters);
  }

  /**
  * Crossover
  *
  * @param Chromosome $other Another chromosome for crossover
  * @return array Two modified chromosomes
  */
  public function crossover(Chromosome $other): array {
    $child1 = clone $this;
    $child2 = clone $other;
    $idx1 = rand(0, count($this->letters) - 1);
    $idx2 = rand(0, count($this->letters) - 1);
    $l1 = $child1->letters[$idx1];
    $l2 = $child2->letters[$idx2];
    $child1->letters[array_search($l2, $child1->letters)] = $child1->letters[$idx2];
    $child1->letters[$idx2] = $l2;
    $child2->letters[array_search($l1, $child2->letters)] = $child2->letters[$idx1];
    $child2->letters[$idx1] = $l1;
    return [$child1, $child2];
  }

  /**
  * Mutate: swap two letters' locations
  */
  public function mutate() {
    $idx1 = rand(0, count($this->letters) - 1);
    $idx2 = rand(0, count($this->letters) - 1);
    $helper = $this->letters[$idx1];
    $this->letters[$idx1] = $this->letters[$idx2];
    $this->letters[$idx2] = $helper;
  }

  /**
  * String representation
  *
  * @return string
  */
  public function __toString() {
    $s = array_search('S', $this->letters);
    $e = array_search('E', $this->letters);
    $n = array_search('N', $this->letters);
    $d = array_search('D', $this->letters);
    $m = array_search('M', $this->letters);
    $o = array_search('O', $this->letters);
    $r = array_search('R', $this->letters);
    $y = array_search('Y', $this->letters);
    $send = $s * 1000 + $e * 100 + $n * 10 + $d;
    $more = $m * 1000 + $o * 100 + $r * 10 + $e;
    $money = $m * 10000 + $o * 1000 + $n * 100 + $e * 10 + $y;
    $difference = abs($money - ($send + $more));
    return sprintf('%d + %d = %d; Difference: %d', $send, $more, $money, $difference);
  }
}
