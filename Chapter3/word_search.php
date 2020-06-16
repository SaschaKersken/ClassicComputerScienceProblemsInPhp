<?php

require_once(__DIR__.'/../Autoloader.php');

/**
* Generate the grid and fill it with random letters
*
* @param int $rows Number of rows
* @param int $columns Number of columns
* @return array The grid
*/
function generateGrid(int $rows, int $columns): array {
  $grid = [];
  for ($i = 0; $i < $rows; $i++) {
    $grid[$i] = [];
    for ($j = 0; $j < $columns; $j++) {
      $grid[$i][] = chr(rand(65, 90));
    }
  }
  return $grid;
}

/**
* Display a grid
*
* @param array $grid
*/
function displayGrid(array $grid) {
  foreach ($grid as $row) {
    Util::out(implode('', $row));
  }
}

/**
* Generate a domain
*
* @param string $word The word
* @param array $grid The grid to fit the word into
* @return array The generatred domain
*/
function generateDomain(string $word, array $grid): array {
  $domain = [];
  $height = count($grid);
  $width = count($grid[0]);
  $length = strlen($word);
  for ($row = 0; $row < $height; $row++) {
    for ($col = 0; $col < $width; $col++) {
      $columns = range($col, $col + $length - 1);
      $rows = range($row, $row + $length - 1);
      if ($col + $length <= $width) {
        // Left to right
        $tempLoc = [];
        foreach ($columns as $c) {
          $tempLoc[] = new GridLocation($row, $c);
        }
        $domain[] = $tempLoc;
        // Diagonal towards bootom right
        if ($row + $length <= $height) {
          $tempLoc = [];
          foreach ($rows as $r) {
            $tempLoc[] = new GridLocation($r, $col + ($r - $row));
          }
          $domain[] = $tempLoc;
        }
      }
      if ($row + $length <= $height) {
        // Top to bottom
        $tempLoc = [];
        foreach ($rows as $r) {
          $tempLoc[] = new GridLocation($r, $col);
        }
        $domain[] = $tempLoc;
        // Diagonal towards bottom left
        if ($col - $length >= 0) {
          $tempLoc = [];
          foreach ($rows as $r) {
            $tempLoc[] = new GridLocation($r, $col - ($r - $row));
          }
          $domain[] = $tempLoc;
        }
      }
    }
  }
  return $domain;
}

$grid = generateGrid(9, 9);
$words = ["MATTHEW", "JOE", "MARY", "SARAH", "SALLY"];
$locations = [];
foreach ($words as $word) {
  $locations[$word] = generateDomain($word, $grid);
}
$csp = new CSP($words, $locations);
$csp->addConstraint(new WordSearchConstraint($words));
$solution = $csp->backtrackingSearch();
if (is_null($solution)) {
  Util::out('No solution found!');
} else {
  foreach ($solution as $word => $gridLocation) {
    if ((bool)rand(0, 1)) {
      $gridLocation = array_reverse($gridLocation);
    }
    foreach (str_split($word) as $index => $letter) {
      $row = $gridLocation[$index]->row;
      $col = $gridLocation[$index]->column;
      $grid[$row][$col] = $letter;
    }
  }
  displayGrid($grid);
}
