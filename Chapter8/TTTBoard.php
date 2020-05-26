<?php

require_once(__DIR__.'/Board.php');
require_once(__DIR__.'/TTTPiece.php');

class TTTBoard implements Board {
  private $position = [];
  private $turn = NULL;

  public function __construct(array $position = NULL, TTTPiece $turn = NULL) {
    if (is_null($position)) {
      $this->position = array_map(
        function() {
          return new TTTPiece(TTTPiece::E);
        },
        range(0, 8)
      );
    } else {
      $this->position = $position;
    }
    if (is_null($turn)) {
      $this->turn = new TTTPiece(TTTPiece::X);
    } else {
      $this->turn = $turn;
    }
  }

  public function turn(): Piece {
    return $this->turn;
  }

  public function move(int $location): Board {
    $tempPosition = $this->position;
    $tempPosition[$location] = $this->turn;
    return new TTTBoard($tempPosition, $this->turn->opposite());
  }

  public function legalMoves(): array {
    return array_keys(
      array_filter(
        $this->position,
        function ($p) {
          return $p->value() == TTTPiece::E;
        }
      )
    );
  }

  public function isWin(): bool {
    $tuples = [
      [0, 1, 2],
      [3, 4, 5],
      [6, 7, 8],
      [0, 3, 6],
      [1, 4, 7],
      [2, 5, 8],
      [0, 4, 8],
      [2, 4, 6]
    ];
    foreach ($tuples as $tuple) {
      $fields = array_map(
        function ($i) {
          return $this->position[$i]->value();
        },
        $tuple
      );
      if ($fields[0] != TTTPiece::E && $fields[0] == $fields[1] && $fields[0] == $fields[2]) {
        return TRUE;
      }
    }
    return FALSE;
  }

  public function isDraw(): bool {
    return !$this->isWin() && count($this->legalMoves()) == 0;
  }

  public function evaluate(Piece $player): float {
    if ($this->isWin() && $this->turn == $player) {
      return -1;
    } elseif ($this->isWin() && $this->turn != $player) {
      return 1;
    } else {
      return 0;
    }
  }

  public function __toString() {
    $result = sprintf(
      "%s|%s|%s\n", $this->position[0], $this->position[1], $this->position[2]
    );
    $result .= "-----\n";
    $result .= sprintf(
      "%s|%s|%s\n", $this->position[3], $this->position[4], $this->position[5]
    );
    $result .= "-----\n";
    $result .= sprintf(
      "%s|%s|%s\n", $this->position[6], $this->position[7], $this->position[8]
    );
    return $result;
  }
}
