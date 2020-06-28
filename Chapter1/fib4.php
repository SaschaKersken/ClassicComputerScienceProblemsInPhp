<?php

require_once(__DIR__.'/../Autoloader.php');

function fib4(int $n): int {
  if ($n == 0) {
    return $n; // Special case
  }
  $last = 0; // Initially set to fib(0)
  $next = 1; // Initially set to fib(1)
  for ($i = 1; $i < $n; $i++) {
    $helper = $last;
    $last = $next;
    $next += $helper;
  }
  return $next;
}

Util::out(fib4(2));
Util::out(fib4(50));
