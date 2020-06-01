<?php

require_once(__DIR__.'/../Util.php');

$memo = [0 => 0, 1 => 1]; // our base cases

function fib3(int $n): int {
  global $memo;
  if (!isset($memo[$n])) {
    $memo[$n] = fib3($n - 1) + fib3($n - 2); // memoization
  }
  return $memo[$n];
}

Util::out(fib3(5));
Util::out(fib3(50));
