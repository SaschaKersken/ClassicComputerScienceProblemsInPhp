<?php

require_once(__DIR__.'/../Output.php');

function fib2(int $n): int {
  if ($n < 2) { // base case
    return $n;
  }
  return fib2($n - 2) + fib2($n - 1); // recursive case
}

Output::out(fib2(5));
Output::out(fib2(10));
