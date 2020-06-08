<?php

require_once(__DIR__.'/../Util.php');

// Note: You may need to increase max_execution_time in php.ini significantly

?>
<!DOCTYPE html>
<html>
<head>
<title>Connect Four</title>
</head>
<body>
<h1>Connect Four</h1>
<?php

if (isset($_GET['board'])) {
  $board = unserialize(base64_decode($_GET['board']));
} else {
  $board = new C4Board();
}

$gameOver = FALSE;
if (isset($_GET['move']) && in_array($_GET['move'], $board->legalMoves())) {
  $board = $board->move($_GET['move']);
  if ($board->isWin()) {
    $gameOver = TRUE;
    echo "<h2>Human wins!</h2>";
  } elseif ($board->isDraw()) {
    $gameOver = TRUE;
    echo "<h2>Draw!</h2>";
  } else {
    $computerMove = AdversarialSearch::findBestMove($board);
    echo "<p>Computer move is $computerMove</p>";
    $board = $board->move($computerMove);
    echo "<p><pre>$board</pre></p>";
    if ($board->isWin()) {
      $gameOver = TRUE;
      echo "<h2>Computer wins!</h2>";
    } elseif ($board->isDraw()) {
      $gameOver = TRUE;
      echo "<h2>Draw!</h2>";
    }
  }
}
if (!$gameOver) {
  echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="GET">';
  echo '<input type="hidden" name="board" value="'.base64_encode(serialize($board)).'" />';
  echo '<p>Enter legal move (0-6): <input type="text" name="move" /></p>';
  echo '<input type="submit" value="Play" />';
  echo '</form>';
} else {
  echo '<a href="'.$_SERVER['SCRIPT_NAME'].'">Play again</a>';
}

?>
</body>
</html>
