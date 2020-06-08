<?php

require_once(__DIR__.'/../../Util.php');

/**
* AdversarialSearch class
*
* The minimax and alpha-beta pruning algorithms for adversarial search
*
* @package ClassicComputerScienceProblemsInPhp
*/
class AdversarialSearch {
  /**
  * Minimax algorithm
  *
  * Find the best possible outcome for original player
  *
  * @param Board $board The board with possible moves and current position
  * @param bool $maximizing Are we maximizing (TRUE) or minimizing (FALSE)?
  * @param Piece $originalPlayer Player whose turn it is
  * @param int $maxDepth Search depth optional, default 8
  * @return float Best move evaluation
  */
  public static function minimax(Board $board, bool $maximizing,
      Piece $originalPlayer, int $maxDepth = 8): float {
    // Base case – terminal position or maximum depth reached
    if ($board->isWin() || $board->isDraw() || $maxDepth == 0) {
      return $board->evaluate($originalPlayer);
    }
    // Recursive case - maximize your gains or minimize the opponent's gains
    if ($maximizing) {
      $bestEval = -INF; // arbitrarily low starting point
      foreach ($board->legalMoves() as $move) {
        $result = self::minimax(
          $board->move($move),
          FALSE,
          $originalPlayer,
          $maxDepth - 1
        );
        // We want the move with the highest evaluation
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
      // We want the move with the lowest evaluation
      return $worstEval;
    }
  }

  /**
  * Alpha-beta pruning (optimized minimax)
  *
  * @param Board $board The board with possible moves and current position
  * @param bool $maximizing Are we maximizing (TRUE) or minimizing (FALSE)?
  * @param Piece $originalPlayer Player whose turn it is
  * @param int $maxDepth Search depth optional, default 8
  * @param float $alpha Best evaluation so far optional, default -INF
  * @param float $beta Worst evaluation so far optional, default INF
  * @return float Best move evaluation
  */
  public static function alphabeta(Board $board, bool $maximizing,
      Piece $originalPlayer, int $maxDepth = 8, float $alpha = -INF,
      float $beta = INF): float {
    // Base case – terminal position or maximum depth reached
    if ($board->isWin() || $board->isDraw() || $maxDepth == 0) {
      return $board->evaluate($originalPlayer);
    }
    // Recursive case - maximize your gains or minimize the opponent's gains
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

  /**
  * Find the best possible move in the current position
  *
  * Looking up to $maxDepth ahead
  *
  * @param Board $board The board with possible moves and current position
  * @param int $maxDepth Search depth optional, default 8
  * @return int The best move found during the process
  */
  public static function findBestMove(Board $board, int $maxDepth = 8): int {
    $bestEval = -INF;
    $bestMove = -1;
    foreach ($board->legalMoves() as $move) {
      $result = self::alphabeta(
        $board->move($move),
        FALSE,
        $board->turn(),
        $maxDepth
      );
      if ($result > $bestEval) {
        $bestEval = $result;
        $bestMove = $move;
      }
    }
    return $bestMove;
  }
}
