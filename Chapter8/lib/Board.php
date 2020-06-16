<?php

require_once(__DIR__.'/../../Autoloader.php');

/**
* Board interface
*
* Models the current game position in a board game
*
* @package ClassicComputerScienceProblemsInPhp
*/
interface Board {
  /**
  * Figure out which player's turn it is
  *
  * @return Piece The current player's piece
  */
  public function turn();

  /**
  * Move: add a piece to a location, resulting in a new position
  *
  * @param int $location The location to add a piece to
  * @return mixed The position after the move
  */
  public function move(int $location);

  /**
  * Get a list of legal moves
  *
  * @return array All legal moves
  */
  public function legalMoves(): array;

  /**
  * Is the current position a win?
  *
  * @return TRUE if win, otherwise FALSE
  */
  public function isWin(): bool;

  /**
  * Is the current position a draw?
  *
  * @return TRUE if draw, otherwise FALSE
  */
  public function isDraw(): bool;

  /**
  * Evaluate the current position in terms of winning chance
  *
  * @param Piece $player Indicate whose player's turn it is
  * @return float Score of the current position
  */
  public function evaluate(Piece $player): float;
}
