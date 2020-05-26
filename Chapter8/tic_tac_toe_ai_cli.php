<?php

require_once(__DIR__.'/TTTBoard.php');
require_once(__DIR__.'/AdversarialSearch.php');
require_once(__DIR__.'/../Output.php');

function getPlayerMove(TTTBoard $board): int {
  $playerMove = -1;
  while (!in_array($playerMove, $board->legalMoves())) {
    Output::out("Enter a legal square (0-8): ", TRUE);
    $playerMove = (int)readline();
  }
  return $playerMove;
}

$board = new TTTBoard();

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
