<?php

require_once(__DIR__.'/../Autoloader.php');

$irisParameters = [];
$irisClassifications = [];
$irisSpecies = [];
$irises = [];
$irisFile = fopen(__DIR__.'/iris.csv', 'r');
while ($iris = fgetcsv($irisFile)) {
  $irises[] = $iris;
}
shuffle($irises); // get our lines of data in random order
foreach ($irises as $iris) {
  $parameters = array_slice($iris, 0, 4);
  $irisParameters[] = $parameters;
  $species = $iris[4];
  switch ($species) {
  case 'Iris-setosa':
    $irisClassifications[] = [1.0, 0.0, 0.0];
    break;
  case 'Iris-versicolor':
    $irisClassifications[] = [0.0, 1.0, 0.0];
    break;
  default:
    $irisClassifications[] = [0.0, 0.0, 1.0];
  }
  $irisSpecies[] = $species;
}
$irisParameters = NetworkUtils::normalizeByFeatureScaling($irisParameters);

$irisNetwork = new SigmoidNetwork([4, 6, 3], 0.3);

function irisInterpretOutput(array $output): string {
  if (max($output) == $output[0]) {
    return 'Iris-setosa';
  } elseif (max($output) == $output[1]) {
    return 'Iris-versicolor';
  } else {
    return 'Iris-virginica';
  }
}

// Train over the first 140 irises in the data set 50 times
$irisTrainers = array_slice($irisParameters, 0, 140);
$irisTrainersCorrects = array_slice($irisClassifications, 0, 140);
for ($i = 0; $i < 50; $i++) {
  $irisNetwork->train($irisTrainers, $irisTrainersCorrects);
}

// Test over the last 10 of the irises in the data set
$irisTesters = array_slice($irisParameters, 140);
$irisTestersCorrects = array_slice($irisSpecies, 140);
$irisResults = $irisNetwork->validate(
  $irisTesters,
  $irisTestersCorrects,
  'irisInterpretOutput'
);
Util::out(
  sprintf(
    "%d correct of %d = %.2f%%",
    $irisResults[0],
    $irisResults[1],
    $irisResults[2] * 100
  )
);
