<?php

require_once(__DIR__.'/Piece.php');

class C4Piece implements Piece {
  const B = 'B';
  const R = 'R';
  const E = ' ';

  private $current = self::E;

  public function __construct(string $current) {
    $this->current = $current;
  }

  public function opposite(): Piece {
    switch ($this->current) {
    case self::B:
      return new C4Piece(self::R);
    case self::R:
      return new C4Piece(self::B);
    default:
      return new C4Piece(self::E);
    }
  }

  public function value(): string {
    return $this->current;
  }

  public function __toString(): string {
    return $this->current;
  }
}
