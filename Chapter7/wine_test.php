<?php

require_once(__DIR__.'/NetworkUtils.php');
require_once(__DIR__.'/SigmoidNetwork.php');
require_once(__DIR__.'/../Output.php');

$wineParameters = [];
$wineClassifications = [];
$wineSpecies = [];
$wines = [];
$wineFile = fopen(__DIR__.'/wine.csv', 'r');
while ($wine = fgetcsv($wineFile)) {
  $wines[] = $wine;
}
shuffle($wines);
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

function wineInterpretOutput(array $output): string {
  if (max($output) == $output[0]) {
    return 1;
  } elseif (max($output) == $output[1]) {
    return 2;
  } else {
    return 3;
  }
}

$wineTrainers = array_slice($wineParameters, 0, 150);
$wineTrainersCorrects = array_slice($wineClassifications, 0, 150);
for ($i = 0; $i < 10; $i++) {
  $wineNetwork->train($wineTrainers, $wineTrainersCorrects);
}

$wineTesters = array_slice($wineParameters, 150);
$wineTestersCorrects = array_slice($wineSpecies, 150);
$wineResults = $wineNetwork->validate(
  $wineTesters,
  $wineTestersCorrects,
  'wineInterpretOutput'
);
Output::out(
  sprintf(
    "%d correct of %d = %.2f%%",
    $wineResults[0],
    $wineResults[1],
    $wineResults[2] * 100
  )
);
