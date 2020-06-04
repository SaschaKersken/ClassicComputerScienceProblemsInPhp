<?php

require_once(__DIR__.'/../Util.php');

$wineParameters = [];
$wineClassifications = [];
$wineSpecies = [];
$wines = [];
$wineFile = fopen(__DIR__.'/wine.csv', 'r');
while ($wine = fgetcsv($wineFile)) {
  $wines[] = $wine;
}
shuffle($wines); // get our lines of data in random order
foreach ($wines as $wine) {
  $parameters = array_slice($wine, 1, 13);
  $wineParameters[] = $parameters;
  $species = $wine[0];
  switch ($species) {
  case 1:
    $wineClassifications[] = [1.0, 0.0, 0.0];
    break;
  case 2:
    $wineClassifications[] = [0.0, 1.0, 0.0];
    break;
  default:
    $wineClassifications[] = [0.0, 0.0, 1.0];
  }
  $wineSpecies[] = $species;
}
$wineParameters = NetworkUtils::normalizeByFeatureScaling($wineParameters);

$wineNetwork = new SigmoidNetwork([13, 7, 3], 0.9);

function wineInterpretUtil(array $output): string {
  if (max($output) == $output[0]) {
    return 1;
  } elseif (max($output) == $output[1]) {
    return 2;
  } else {
    return 3;
  }
}

// Train over the first 150 wines 10 times
$wineTrainers = array_slice($wineParameters, 0, 150);
$wineTrainersCorrects = array_slice($wineClassifications, 0, 150);
for ($i = 0; $i < 10; $i++) {
  $wineNetwork->train($wineTrainers, $wineTrainersCorrects);
}

// Test over the last 28 of the wines in the data set
$wineTesters = array_slice($wineParameters, 150);
$wineTestersCorrects = array_slice($wineSpecies, 150);
$wineResults = $wineNetwork->validate(
  $wineTesters,
  $wineTestersCorrects,
  'wineInterpretUtil'
);
Util::out(
  sprintf(
    "%d correct of %d = %.2f%%",
    $wineResults[0],
    $wineResults[1],
    $wineResults[2] * 100
  )
);
