<?php

require_once(__DIR__.'/../Util.php');

/**
* Generate all possible permutations of an array
*
* @param array $items The array to generate permutations for
* @param array &$result Array variable to store the result in
* @param array $permutations optional, default empty array
*/
function permutations($items, &$result, $permutations = []) {
  if (empty($items)) {
    $result[] = $permutations;
  } else {
    for ($i = count($items) - 1; $i >= 0; $i--) {
      $newItems = $items;
      $newPermutations = $permutations;
      list($temp) = array_splice($newItems, $i, 1);
      array_unshift($newPermutations, $temp);
      permutations($newItems, $result, $newPermutations);
    }
  }
}

$vtDistances = [
  'Rutland' => [
    'Burlington' => 67,
    'White River Junction' => 46,
    'Bennington' => 55,
    'Brattleboro' => 75
  ],
  'Burlington' => [
    'Rutland' => 67,
    'White River Junction' => 91,
    'Bennington' => 122,
    'Brattleboro' => 153
  ],
  'White River Junction' => [
    'Rutland' => 46,
    'Burlington' => 91,
    'Bennington' => 98,
    'Brattleboro' => 65
  ],
  'Bennington' => [
    'Rutland' => 55,
    'Burlington' => 122,
    'White River Junction' => 98,
    'Brattleboro' => 40
  ],
  'Brattleboro' => [
    'Rutland' => 75,
    'Burlington' => 153,
    'White River Junction' => 65,
    'Bennington' => 40
  ]
];

$vtCities = array_keys($vtDistances);
permutations($vtCities, $cityPermutations);
$tspPaths = array_map(
  function($path) {
    return array_merge($path, [$path[0]]);
  },
  $cityPermutations
);

$bestPath = [];
$minDistance = 99999999; // arbitrarily high number
foreach ($tspPaths as $path) {
  $distance = 0;
  $last = $path[0];
  foreach (array_slice($path, 1) as $next) {
    $distance += $vtDistances[$last][$next];
    $last = $next;
  }
  if ($distance < $minDistance) {
    $minDistance = $distance;
    $bestPath = $path;
  }
}
Util::out("The shortest path is:");
Util::out($bestPath);
Util::out("in $minDistance miles.");
