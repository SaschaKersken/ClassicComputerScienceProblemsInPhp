<?php

require_once(__DIR__.'/Autoloader.php');

function calculatePi(int $nTerms): float {
  $numerator = 4.0;
  $denominator = 1.0;
  $operation = 1.0;
  $pi = 0.0;
  for ($i = 0; $i < $nTerms; $i++) {
    $pi += $operation * ($numerator / $denominator);
    $denominator += 2.0;
    $operation *= -1.0;
  }
  return $pi;
}

Util::out(calculatePi(100000));
