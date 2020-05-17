<?php

require_once(__DIR__.'/generic_search.php');
require_once(__DIR__.'/../Output.php');
define('MAX_NUM', 3);

class MCState {
  private $wm = MAX_NUM;
  private $wc = MAX_NUM;
  private $em = 0;
  private $ec = 0;
  private $boat = FALSE;

  public function __construct(int $missionaries, int $cannibals, bool $boat) {
    $this->wm = $missionaries;
    $this->wc = $cannibals;
    $this->em = MAX_NUM - $this->wm;
    $this->ec = MAX_NUM - $this->wc;
    $this->boat = $boat;
  }

  public function __toString() {
    $output = sprintf("There are %d missionaries and %d cannibals on the west bank.\n", $this->wm, $this->wc);
    $output .= sprintf("There are %d missionaires and %d cannibals on the east bank.\n", $this->em, $this->ec);
    $output .= sprintf("The boat is on the %s bank.", $this->boat ? "west" : "east");
    return $output;
  }

  public function isLegal(): bool {
    if ($this->wm < $this->wc && $this->wm > 0) {
      return FALSE;
    }
    if ($this->em < $this->ec && $this->em > 0) {
      return FALSE;
    }
    return TRUE;
  }


  public function __get($property) {
    switch ($property) {
    case 'wm':
      return $this->wm;
    case 'wc':
      return $this->wc;
    case 'em':
      return $this->em;
    case 'ec':
      return $this->ec;
    case 'boat':
      return $this->boat;
    }
  }

  public static function goalTest(MCState $state): bool {
    return $state->isLegal() && $state->em == MAX_NUM && $state->ec == MAX_NUM;
  }

  public static function successors(MCState $state): array {
    $sucs = [];
    if ($state->boat) {
      if ($state->wm > 1) {
        $sucs[] = new MCState($state->wm - 2, $state->wc, !$state->boat);
      }
      if ($state->wm > 0) {
        $sucs[] = new MCState($state->wm - 1, $state->wc, !$state->boat);
      }
      if ($state->wc > 1) {
        $sucs[] = new MCState($state->wm, $state->wc - 2, !$state->boat);
      }
      if ($state->wc > 0) {
        $sucs[] = new MCState($state->wm, $state->wc - 1, !$state->boat);
      }
      if ($state->wc > 0 && $state->wm > 0) {
        $sucs[] = new MCState($state->wm - 1, $state->wc - 1, !$state->boat);
      }
    } else {
      if ($state->em > 1) {
        $sucs[] = new MCState($state->wm + 2, $state->wc, !$state->boat);
      }
      if ($state->em > 0) {
        $sucs[] = new MCState($state->wm + 1, $state->wc, !$state->boat);
      }
      if ($state->ec > 1) {
        $sucs[] = new MCState($state->wm, $state->wc + 2, !$state->boat);
      }
      if ($state->ec > 0) {
        $sucs[] = new MCState($state->wm, $state->wc + 1, !$state->boat);
      }
      if ($state->ec > 0 && $state->em > 0) {
        $sucs[] = new MCState($state->wm + 1, $state->wc + 1, !$state->boat);
      }
    }
    return array_filter(
      $sucs,
      function($state) {
        return $state->isLegal();
      }
    );
  }
}

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

$start = new MCState(MAX_NUM, MAX_NUM, TRUE);
$solution = bfs($start, ['MCState', 'goalTest'], ['MCState', 'successors']);
if (is_null($solution)) {
  Output::out('No solution found!');
} else {
  $path = nodeToPath($solution);
  displaySolution($path);
}
