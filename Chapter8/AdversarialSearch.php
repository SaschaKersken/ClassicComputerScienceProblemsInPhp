<?php

require_once(__DIR__.'/Board.php');
require_once(__DIR__.'/Piece.php');

class AdversarialSearch {
  public static function minimax(Board $board, bool $maximizing, Piece $originalPlayer, int $maxDepth = 8): float {
    if ($board->isWin() || $board->isDraw() || $maxDepth == 0) {
      return $board->evaluate($originalPlayer);
    }
    if ($maximizing) {
      $bestEval = -INF;
      foreach ($board->legalMoves() as $move) {
        $result = self::minimax(
          $board->move($move),
          FALSE,
          $originalPlayer,
          $maxDepth - 1
        );
        $bestEval = max($result, $bestEval);
      }
      return $bestEval;
    } else { // minimizing
      $worstEval = INF;
      foreach ($board->legalMoves as $move) {
        $result = minimax(
          $board->move($move),
          TRUE,
          $originalPlayer,
          $maxDepth - 1
        );
        $worstEval = min($result, $worstEval);
      }
      return $worstEval;
    }
  }

  public static function alphabeta(Board $board, bool $maximizing, Piece $originalPlayer, int $maxDepth = 8, float $alpha = -INF, float $beta = INF): float {
    if ($board->isWin() || $board->isDraw() || $maxDepth == 0) {
      return $board->evaluate($originalPlayer);
    }
    if ($maximizing) {
      foreach ($board->legalMoves() as $move) {
        $result = self::alphabeta(
          $board->move($move),
          FALSE,
          $originalPlayer,
          $maxDepth - 1,
          $alpha,
          $beta
        );
        $alpha = max($result, $alpha);
        if ($beta <= $alpha) {
          break;
        }
      }
      return $alpha;
    } else { // minimizing
      foreach ($board->legalMoves() as $move) {
        $result = self::alphabeta(
          $board->move($move),
          TRUE,
          $originalPlayer,
          $maxDepth - 1,
          $alpha,
          $beta
        );
        $beta = min($result, $beta);
        if ($beta <= $alpha) {
          break;
        }
      }
      return $beta;
    }
  }

  public static function findBestMove(Board $board, int $maxDepth = 8): int {
    $bestEval = -INF;
    $bestMove = -1;
    foreach ($board->legalMoves() as $move) {
      $result = self::alphabeta($board->move($move), FALSE, $board->turn(), $maxDepth);
      if ($result > $bestEval) {
        $bestEval = $result;
        $bestMove = $move;
      }
    }
    return $bestMove;
  }
}
