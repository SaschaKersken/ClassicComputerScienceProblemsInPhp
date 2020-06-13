<?php

require_once(__DIR__.'/../../Util.php');

/**
* C4Board class
*
* Represents the board in Connect Four
*
* @package ClassicComputerScienceProblemsInPhp
*/
class C4Board implements Board {
  const NUM_ROWS = 6;
  const NUM_COLUMNS = 7;
  const SEGMENT_LENGTH = 4;

  /**
  * Segments to look at for winning moves
  * @var array
  */
  private static $segments = [];

  /**
  * Current playing position
  * @var array
  */
  private $position = [];

  /**
  * Indicate whose turn it is
  * @var C4Piece
  */
  private $_turn = NULL;

  /**
  * Constructor
  *
  * @param array $position Current playing position optional, default NULL
  * @param C4Piece $turn Indicate whose turn it is optional, default NULL
  */
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

  /**
  * Piece that indicates whose turn it is
  *
  * @return Piece The piece indicating the current turn
  */
  public function turn(): Piece {
    return $this->_turn;
  }

  /**
  * Move: push a piece into the indicated column
  *
  * @param int $location The column to push a piece into
  * @return Board Game position after the move
  */
  public function move(int $location): Board {
    $tempPosition = [];
    for ($i = 0; $i < self::NUM_COLUMNS; $i++) {
      $tempPosition[] = clone $this->position[$i];
    }
    $tempPosition[$location][] = $this->_turn;
    return new C4Board($tempPosition, $this->_turn->opposite());
  }

  /**
  * Get the list of legal moves
  *
  * @return array Legal moves
  */
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

  /**
  * Return the count of red & black pieces in a segment
  *
  * @param array $segment The segment to check
  * @return array Number of black pieces, number of red pieces
  */
  protected function countSegment(array $segment): array {
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

  /**
  * Is the current position a win?
  *
  * @return bool TRUE if win, otherwise FALSE
  */
  public function isWin(): bool {
    foreach ($this->getSegments() as $segment) {
      list($blackCount, $redCount) = $this->countSegment($segment);
      if ($blackCount == 4 || $redCount == 4) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
  * Is the current position a draw?
  *
  * @return bool TRUE if win, otherwise FALSE
  */
  public function isDraw(): bool {
    return !$this->isWin() && count($this->legalMoves()) == 0;
  }

  /**
  * Evaluate a segment
  *
  * @param array $segment The segment to evaluate
  * @param Piece $player Player whose turn it is
  * @return float Score for the pieces in the segment
  */
  protected function evaluateSegment(array $segment, Piece $player): float {
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

  /**
  * Evaluate the current position
  *
  * @param Piece $player Player whose turn it is
  * @return float Total score for this position
  */
  public function evaluate(Piece $player): float {
    $total = 0;
    foreach (self::$segments as $segment) {
      $total += $this->evaluateSegment($segment, $player);
    }
    return $total;
  }

  /**
  * Get all segments (generate them if this hasn't happened yet)
  *
  * @return array List of all segments
  */
  public static function getSegments(): array {
    if (empty(self::$segments)) {
      self::generateSegments();
    }
    return self::$segments;
  }

  /**
  * Generate all segments
  */
  public static function generateSegments() {
    // Generate the vertical segments
    for ($c = 0; $c < self::NUM_COLUMNS; $c++) {
      for ($r = 0; $r <= self::NUM_ROWS - self::SEGMENT_LENGTH; $r++) {
        $segment = [];
        for ($t = 0; $t < self::SEGMENT_LENGTH; $t++) {
          $segment[] = [$c, $r + $t];
        }
        self::$segments[] = $segment;
      }
    }

    // Generate the horizontal segments
    for ($c = 0; $c <= self::NUM_COLUMNS - self::SEGMENT_LENGTH; $c++) {
      for ($r = 0; $r < self::NUM_ROWS; $r++) {
        $segment = [];
        for ($t = 0; $t < self::SEGMENT_LENGTH; $t++) {
          $segment[] = [$c + $t, $r];
        }
        self::$segments[] = $segment;
      }
    }

    // Generate the bottom left to top right diagonal segments
    for ($c = 0; $c <= self::NUM_COLUMNS - self::SEGMENT_LENGTH; $c++) {
      for ($r = 0; $r <= self::NUM_ROWS - self::SEGMENT_LENGTH; $r++) {
        $segment = [];
        for ($t = 0; $t < self::SEGMENT_LENGTH; $t++) {
          $segment[] = [$c + $t, $r + $t];
        } 
        self::$segments[] = $segment;
      }
    }

    // Generate the top left to bottom right diagonal segments
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

  /**
  * String representation
  *
  * @return string The string representation
  */
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
