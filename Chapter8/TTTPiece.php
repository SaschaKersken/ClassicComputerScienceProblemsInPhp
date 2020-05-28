<?php

require_once(__DIR__.'/Piece.php');

class TTTPiece implements Piece {
  const X = 'X';
  const O = 'O';
  const E = ' ';

  private $current = self::E;

  public function __construct(string $current) {
    $this->current = $current;
  }

  public function opposite(): Piece {
    switch ($this->current) {
    case self::X:
      return new TTTPiece(self::O);
    case self::O:
      return new TTTPiece(self::X);
    default:
      return new TTTPiece(self::E);
    }
  }

  public function value(): string {
    return $this->current;
  }

  public function __toString():string {
    return $this->current;
  }
}
