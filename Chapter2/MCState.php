<?php

/**
* MCState class
*
* Represents a state in the 'missionaries and cannibals' puzzle
*
* @package ClassicComputerScienceProblemsInPhp
*/
class MCState {
  const MAX_NUM = 3;

  private $wm = self::MAX_NUM;
  private $wc = self::MAX_NUM;
  private $em = 0;
  private $ec = 0;
  private $boat = FALSE;

  public function __construct(int $missionaries, int $cannibals, bool $boat) {
    $this->wm = $missionaries;
    $this->wc = $cannibals;
    $this->em = self::MAX_NUM - $this->wm;
    $this->ec = self::MAX_NUM - $this->wc;
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
    return $state->isLegal() && $state->em == self::MAX_NUM && $state->ec == self::MAX_NUM;
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
