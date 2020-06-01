<?php

require_once(__DIR__.'/csp.php');
require_once(__DIR__.'/../Util.php');

class SendMoreMoneyConstraint extends Constraint {
  private $letters = [];

  public function __construct(array $letters) {
    parent::__construct($letters);
    $this->letters = $letters;
  }

  public function satisfied(array $assignment):bool {
    if (count(array_unique($assignment)) < count($assignment)) {
      return FALSE;
    }

    if (count($assignment) == count($this->letters)) {
      $s = $assignment['S'];
      $e = $assignment['E'];
      $n = $assignment['N'];
      $d = $assignment['D'];
      $m = $assignment['M'];
      $o = $assignment['O'];
      $r = $assignment['R'];
      $y = $assignment['Y'];
      $send = $s * 1000 + $e * 100 + $n * 10 + $d;
      $more = $m * 1000 + $o * 100 + $r * 10 + $e;
      $money = $m * 10000 + $o * 1000 + $n * 100 + $e * 10 + $y;
      return $send + $more == $money;
    }

    return TRUE;
  }
}

$letters = ["S", "E", "N", "D", "M", "O", "R", "Y"];
$possibleDigits = [];
foreach ($letters as $letter) {
  $possibleDigits[$letter] = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
}
$possibleDigits['M'] = [1];
$csp = new CSP($letters, $possibleDigits);
$csp->addConstraint(new SendMoreMoneyConstraint($letters));
$solution = $csp->backtrackingSearch();
if (is_null($solution)) {
  Util::out('No solution found!');
} else {
  Util::out($solution);
}
