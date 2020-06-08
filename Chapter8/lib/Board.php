<?php

require_once(__DIR__.'/../../Util.php');

interface Board {
  public function turn();

  public function move(int $location);

  public function legalMoves(): array;

  public function isWin(): bool;

  public function isDraw(): bool;

  public function evaluate(Piece $player): float;
}
