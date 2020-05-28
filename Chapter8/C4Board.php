<?php

require_once(__DIR__.'/Board.php');
require_once(__DIR__.'/C4Piece.php');
require_once(__DIR__.'/C4Column.php');

class C4Board implements Board {
  const NUM_ROWS = 6;
  const NUM_COLUMNS = 7;
  const SEGMENT_LENGTH = 4;

  private static $segments = [];

  private $position = [];
  private $_turn = NULL;

  public function __construct(array $position = NULL, C4Piece $turn = NULL) {
    if (is_null($position)) {
      $this->position = array_map(
        function() {
          return new C4Column();
        },
        range(0, self::NUM_COLUMNS - 1)
      );
    } else {
      $this->position = $position;
    }
    if (is_null($turn)) {
      $this->_turn = new C4Piece(C4Piece::B);
    } else {
      $this->_turn = $turn;
    }
  }

  public function turn(): Piece {
    return $this->_turn;
  }

  public function move(int $location): Board {
    $tempPosition = [];
    for ($i = 0; $i < self::NUM_COLUMNS; $i++) {
      $tempPosition[] = clone $this->position[$i];
    }
    $tempPosition[$location][] = $this->_turn;
    return new C4Board($tempPosition, $this->_turn->opposite());
  }

  public function legalMoves(): array {
    return array_keys(
      array_filter(
        $this->position,
        function ($column) {
          return !$column->full();
        }
      )
    );
  }

  private function countSegment(array $segment): array {
    $blackCount = 0;
    $redCount = 0;
    foreach ($segment as list($column, $row)) {
      if ($this->position[$column][$row]->value() == C4Piece::B) {
        $blackCount++;
      } elseif ($this->position[$column][$row]->value() == C4Piece::R) {
        $redCount++;
      }
    }
    return [$blackCount, $redCount];
  }

private function _segmentToString($segment) {
  $result = '<';
  foreach ($segment as list($column, $row)) {
    $result .= $this->position[$column][$row]->value();
  }
  $result .= '>';
  return $result;
}
  public function isWin(): bool {
    foreach ($this->getSegments() as $segment) {
      list($blackCount, $redCount) = $this->countSegment($segment);
//if ($blackCount > 0 || $redCount > 0) { printf("%s - Black: %d - Red: %d\n", $this->_segmentToString($segment), $blackCount, $redCount); }
      if ($blackCount == 4 || $redCount == 4) {
        return TRUE;
      }
    }
    return FALSE;
  }

  public function isDraw(): bool {
    return !$this->isWin() && count($this->legalMoves()) == 0;
  }

  private function evaluateSegment(array $segment, Piece $player): float {
    list($blackCount, $redCount) = $this->countSegment($segment);
    if ($redCount > 0 && $blackCount > 0) {
      return 0; // mixed segments are neutral
    }
    $count = max($redCount, $blackCount);
    $score = 0;
    if ($count == 2) {
      $score = 1;
    } elseif ($count == 3) {
      $score = 100;
    } elseif ($count == 4) {
      $score = 1000000;
    }
    $color = new C4Piece(C4Piece::B);
    if ($redCount > $blackCount) {
      $color = new C4Piece(C4Piece::R);
    }
    if ($color != $player) {
      return -$score;
    }
    return $score;
  }

  public function evaluate(Piece $player): float {
    $total = 0;
    foreach (self::$segments as $segment) {
      $total += $this->evaluateSegment($segment, $player);
    }
    return $total;
  }

  public static function getSegments(): array {
    if (empty(self::$segments)) {
      self::generateSegments();
    }
    return self::$segments;
  }

  public static function generateSegments() {
    for ($c = 0; $c < self::NUM_COLUMNS; $c++) {
      for ($r = 0; $r <= self::NUM_ROWS - self::SEGMENT_LENGTH; $r++) {
        $segment = [];
        for ($t = 0; $t < self::SEGMENT_LENGTH; $t++) {
          $segment[] = [$c, $r + $t];
        }
        self::$segments[] = $segment;
      }
    }

    for ($c = 0; $c <= self::NUM_COLUMNS - self::SEGMENT_LENGTH; $c++) {
      for ($r = 0; $r < self::NUM_ROWS; $r++) {
        $segment = [];
        for ($t = 0; $t < self::SEGMENT_LENGTH; $t++) {
          $segment[] = [$c + $t, $r];
        }
        self::$segments[] = $segment;
      }
    }

    for ($c = 0; $c <= self::NUM_COLUMNS - self::SEGMENT_LENGTH; $c++) {
      for ($r = 0; $r <= self::NUM_ROWS - self::SEGMENT_LENGTH; $r++) {
        $segment = [];
        for ($t = 0; $t < self::SEGMENT_LENGTH; $t++) {
          $segment[] = [$c + $t, $r + $t];
        } 
        self::$segments[] = $segment;
      }
    }

    for ($c = 0; $c <= self::NUM_COLUMNS - self::SEGMENT_LENGTH; $c++) {
      for ($r = self::SEGMENT_LENGTH - 1; $r < self::NUM_ROWS; $r++) {
        $segment = [];
        for ($t = 0; $t < self::SEGMENT_LENGTH; $t++) {
          $segment[] = [$c + $t, $r - $t];
        }
        self::$segments[] = $segment;
      }
    }
  } 

  public function __toString(): string {
    $display = '';
    for ($r = self::NUM_ROWS - 1; $r >= 0; $r--) {
      $display .= '|';
      for ($c = 0; $c < self::NUM_COLUMNS; $c++) {
        $display .= $this->position[$c][$r]->value().'|';
      }
      $display .= PHP_EOL;
    }
    return $display;
  }
}
