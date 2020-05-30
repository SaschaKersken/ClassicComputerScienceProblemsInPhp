<?php

require_once(__DIR__.'/../Output.php');

function permutations($items, &$result, $perms = []) {
  if (empty($items)) {
    $result[] = $perms;
  } else {
    for ($i = count($items) - 1; $i >= 0; $i--) {
      $newItems = $items;
      $newPerms = $perms;
      list($foo) = array_splice($newItems, $i, 1);
      array_unshift($newPerms, $foo);
      permutations($newItems, $result, $newPerms);
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
Output::out("The shortest path is:");
Output::out($bestPath);
Output::out("in $minDistance miles.");
