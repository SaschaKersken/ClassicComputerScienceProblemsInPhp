<?php

require_once(__DIR__.'/../../Util.php');

/**
* C4Piece class
*
* Represents a piece in Connect Four
*
* @package ClassicComputerScienceProblemsInPhp
*/
class C4Piece implements Piece {
  const B = 'B';
  const R = 'R';
  const E = ' '; // Stand-in for empty

  /**
  * Current value
  * @var string
  */
  private $current = self::E;

  /**
  * Constructor
  *
  * @param string $current Current value
  */
  public function __construct(string $current) {
    $this->current = $current;
  }

  /**
  * Get opposite player's piece
  *
  * @return Piece
  */
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

  /**
  * Get the current value
  *
  * @return string The current value
  */
  public function value(): string {
    return $this->current;
  }

  /**
  * String representation
  *
  * @return string The current value
  */
  public function __toString(): string {
    return $this->current;
  }
}
