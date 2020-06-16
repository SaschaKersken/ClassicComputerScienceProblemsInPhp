<?php

require_once(__DIR__.'/../Autoloader.php');

function fib2(int $n): int {
  if ($n < 2) { // base case
    return $n;
  }
  return fib2($n - 2) + fib2($n - 1); // recursive case
}

Util::out(fib2(5));
Util::out(fib2(10));
