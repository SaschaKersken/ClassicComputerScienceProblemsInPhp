<?php

require_once(__DIR__.'/C4Board.php');
require_once(__DIR__.'/AdversarialSearch.php');
require_once(__DIR__.'/../Util.php');

function getPlayerMove(C4Board $board): int {
  $playerMove = -1;
  while (!in_array($playerMove, $board->legalMoves())) {
    Util::out("Enter a legal column (0-6): ", TRUE);
    $playerMove = (int)readline();
  }
  return $playerMove;
}

$board = new C4Board();

// Main game loop
while (TRUE) {
  $humanMove = getPlayerMove($board);
  $board = $board->move($humanMove);
  if ($board->isWin()) {
    Util::out('Human wins!');
    break;
  } elseif ($board->isDraw()) {
    Util::out('Draw!');
    break;
  }
  $computerMove = AdversarialSearch::findBestMove($board);
  Util::out("Computer move is $computerMove");
  $board = $board->move($computerMove);
  Util::out($board);
  if ($board->isWin()) {
    Util::out('Computer wins!');
    break;
  } elseif ($board->isDraw()) {
    Util::out('Draw!');
    break;
  }
}
