<?php

/**
* Piece interface
*
* Represents a specific player's piece in a game
*
* @package ClassicComputerScienceProblemsInPhp
*/
interface Piece {
  /**
  * Return the opposite player's piece (typically their color)
  *
  * @return Piece The opposite player's piece
  */
  public function opposite(): Piece;
}

