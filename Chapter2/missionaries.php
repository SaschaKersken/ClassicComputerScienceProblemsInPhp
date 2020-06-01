<?php

require_once(__DIR__.'/generic_search.php');
require_once(__DIR__.'/../Util.php');

function displaySolution(array $path) {
  if (count($path) == 0) {
    return;
  }
  $oldState = $path[0];
  Util::out($oldState);
  foreach (array_slice($path, 1) as $currentState) {
    if ($currentState->boat) {
      Util::out(sprintf("Transported %d missionaries and %d cannibals from the east bank to the west bank.", $oldState->em - $currentState->em, $oldState->ec - $currentState->ec));
    } else {
      Util::out(sprintf("Transported %d missionaries and %d cannibals from the west bank to the east bank.", $oldState->wm - $currentState->wm, $oldState->wc - $currentState->wc));
    }
    Util::out($currentState);
    $oldState = $currentState;
  }
}

$start = new MCState(MCState::MAX_NUM, MCState::MAX_NUM, TRUE);
$solution = bfs($start, ['MCState', 'goalTest'], ['MCState', 'successors']);
if (is_null($solution)) {
  Util::out('No solution found!');
} else {
  $path = nodeToPath($solution);
  displaySolution($path);
}
