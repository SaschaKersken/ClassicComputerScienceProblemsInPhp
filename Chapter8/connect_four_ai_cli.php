<?php

require_once(__DIR__.'/C4Board.php');
require_once(__DIR__.'/AdversarialSearch.php');
require_once(__DIR__.'/../Output.php');

function getPlayerMove(C4Board $board): int {
  $playerMove = -1;
  while (!in_array($playerMove, $board->legalMoves())) {
    Output::out("Enter a legal column (0-6): ", TRUE);
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
    Output::out('Human wins!');
    break;
  } elseif ($board->isDraw()) {
    Output::out('Draw!');
    break;
  }
  $computerMove = AdversarialSearch::findBestMove($board);
  Output::out("Computer move is $computerMove");
  $board = $board->move($computerMove);
  Output::out($board);
  if ($board->isWin()) {
    Output::out('Computer wins!');
    break;
  } elseif ($board->isDraw()) {
    Output::out('Draw!');
    break;
  }
}
