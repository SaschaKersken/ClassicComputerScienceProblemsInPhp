<?php

require_once(__DIR__.'/../../Autoloader.php');

/**
* TTTPiece class
*
* Piece in a tic-tac-toe game
*
* @package ClassicComputerScienceProblemsInPhp
*/
class TTTPiece implements Piece {
  const X = 'X';
  const O = 'O';
  const E = ' '; // Stand-in for empty

  /**
  * Current value
  * @var string
  */
  private $current = self::E;

  /**
  * Constructor
  *
  * @param string $current The current value
  */
  public function __construct(string $current) {
    $this->current = $current;
  }

  /**
  * Get the opposite player's piece
  *
  * @return Piece
  */
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

  /**
  * Get current value
  *
  * @return string Current value
  */
  public function value(): string {
    return $this->current;
  }

  /**
  * String representation
  *
  * @return string Current value
  */
  public function __toString():string {
    return $this->current;
  }
}
