<?php

require_once(__DIR__.'/generic_search.php');
require_once(__DIR__.'/MCState.php');
require_once(__DIR__.'/../Output.php');

function displaySolution(array $path) {
  if (count($path) == 0) {
    return;
  }
  $oldState = $path[0];
  Output::out($oldState);
  foreach (array_slice($path, 1) as $currentState) {
    if ($currentState->boat) {
      Output::out(sprintf("Transported %d missionaries and %d cannibals from the east bank to the west bank.", $oldState->em - $currentState->em, $oldState->ec - $currentState->ec));
    } else {
      Output::out(sprintf("Transported %d missionaries and %d cannibals from the west bank to the east bank.", $oldState->wm - $currentState->wm, $oldState->wc - $currentState->wc));
    }
    Output::out($currentState);
    $oldState = $currentState;
  }
}

$start = new MCState(MCState::MAX_NUM, MCState::MAX_NUM, TRUE);
$solution = bfs($start, ['MCState', 'goalTest'], ['MCState', 'successors']);
if (is_null($solution)) {
  Output::out('No solution found!');
} else {
  $path = nodeToPath($solution);
  displaySolution($path);
}
