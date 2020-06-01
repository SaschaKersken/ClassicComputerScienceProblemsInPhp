<?php

require_once(__DIR__.'/../Util.php');

function fib5(int $n): int {
  if ($n == 0) {
    return $n; // Special case
  }
  $last = 0; // Initially set to fib(0)
  $next = 1; // Initially set to fib(1)
  for ($i = 1; $i <= $n; $i++) {
    $last = $next;
    $next = $last + $next;
  }
  return $next;
}

Util::out(fib5(2));
Util::out(fib5(50));
