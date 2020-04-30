<?php

function fib1(int $n): int {
  return fib1($n - 1) + fib2($n - 2);
}

echo fib1(5);
# Note that this example is purposefully wrong.
