<?php

/**
* MCState class
*
* Represents a state in the 'missionaries and cannibals' puzzle
*
* @package ClassicComputerScienceProblemsInPhp
* @property int $wm West bank missionaries
* @property int $wc West bank cannibals
* @property int $em East bank missionaries
* @property int $ec East bank cannibals
* @property bool $boat Boat on west bank?
*/
class MCState {
  const MAX_NUM = 3;

  /**
  * West bank missionaries
  * @var int
  */
  private $wm = self::MAX_NUM; 

  /**
  * West bank cannibals
  * @var int
  */
  private $wc = self::MAX_NUM;

  /**
  * East bank missionaries
  * @var int
  */
  private $em = 0;

  /**
  * East bank cannibals
  * @var int
  */
  private $ec = 0; 

  /**
  * Boat on west bank?
  * @var bool
  */
  private $boat = FALSE;

  /**
  * Constructor
  *
  * @param int $missionaries Missionaries on west bank
  * @param int $cannibals Cannibals on west bank
  * @param bool $boat Boat on west bank?
  */
  public function __construct(int $missionaries, int $cannibals, bool $boat) {
    $this->wm = $missionaries;
    $this->wc = $cannibals;
    $this->em = self::MAX_NUM - $this->wm;
    $this->ec = self::MAX_NUM - $this->wc;
    $this->boat = $boat;
  }

  /**
  * String representation
  *
  * @return string
  */
  public function __toString(): string {
    $output = sprintf("There are %d missionaries and %d cannibals on the west bank.\n", $this->wm, $this->wc);
    $output .= sprintf("There are %d missionaries and %d cannibals on the east bank.\n", $this->em, $this->ec);
    $output .= sprintf("The boat is on the %s bank.", $this->boat ? "west" : "east");
    return $output;
  }

  /**
  * Is this state legal?
  *
  * @return bool
  */
  public function isLegal(): bool {
    if ($this->wm < $this->wc && $this->wm > 0) {
      return FALSE;
    }
    if ($this->em < $this->ec && $this->em > 0) {
      return FALSE;
    }
    return TRUE;
  }

  /**
  * Magic getter method
  *
  * @param string $property Property to read
  * @return mixed Value of the property
  */
  public function __get(string $property) {
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

  /**
  * Goal test
  *
  * @param MCState $state State to check as possible goal
  * @return bool TRUE if goal reached, otherwise FALSE
  */
  public static function goalTest(MCState $state): bool {
    return $state->isLegal() &&
      $state->em == self::MAX_NUM && $state->ec == self::MAX_NUM;
  }

  /**
  * Get successors for a state
  *
  * @param MCState $state The state to find successors for
  * @return array List of successors
  */
  public static function successors(MCState $state): array {
    $sucs = [];
    if ($state->boat) { // Boat on west bank
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
    } else { // Boat on east bank
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
