<?php

require_once(__DIR__.'/../Output.php');

function fib6(int $n) {
  yield 0; // Special case
  if ($n > 0) {
    yield 1; // Special case
    $last = 0; // Initially set to fib(0)
    $next = 1; // Initially set to fib(1)
    for ($i = 1; $i <= $n; $i++) {
      $last = $next;
      $next = $last + $next;
      yield $next; // Main generator step
    }
  }
}

foreach(fib6(50) as $i) {
   Output::out($i);
}
