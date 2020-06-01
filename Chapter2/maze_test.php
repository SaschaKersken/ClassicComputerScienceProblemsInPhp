<?php

require_once(__DIR__.'/SearchState.php');
require_once(__DIR__.'/Maze.php');
require_once(__DIR__.'/MazeLocation.php');
require_once(__DIR__.'/generic_search.php');
require_once(__DIR__.'/../Output.php');

/**
* Generate a function to calculate the euclidian distance to a goal
*
* @param MazeLocation $goal The goal to calculate the distance to
* @return callable Function to calculate the euclidian distance to $goal
*/
function euclidianDistance(MazeLocation $goal) {
  return function(MazeLocation $ml) use($goal): float {
    $xdist = $ml->column - $goal->column;
    $ydist = $ml->row - $goal->row;
    return sqrt(($xdist * $xdist) + ($ydist * $ydist));
  };
}

/**
* Generate a function to calculate the Manhattan distance to a goal
*
* @param MazeLocation $goal The goal to calculate the distance to
* @return callable Function to calculate the Manhattan distance to $goal
*/
function manhattanDistance(MazeLocation $goal) {
  return function(MazeLocation $ml) use($goal): float {
    $xdist = abs($ml->column - $goal->column);
    $ydist = abs($ml->row - $goal->row);
    return $xdist + $ydist;
  };
}

$m = new Maze();
Output::out($m);
Output::out('Depth-first search:');
$solution1 = dfs($m->getStart(), [$m, 'goalTest'], [$m, 'successors']);
if (is_null($solution1)) {
  Output::out('Found no solution using DFS');
} else {
  $path1 = nodeToPath($solution1);
  $m->mark($path1);
  Output::out($m);
  $m->clear($path1);
}
Output::out('Breadth-first search:');
$solution2 = bfs($m->getStart(), [$m, 'goalTest'], [$m, 'successors']);
if (is_null($solution2)) {
  Output::out('Found no solution using BFS.');
} else {
  $path2 = nodeToPath($solution2);
  $m->mark($path2);
  Output::out($m);
  $m->clear($path2);
}
Output::out('A* with euclidian distance');
$distance = euclidianDistance($m->getGoal());
$solution3 = astar($m->getStart(), [$m, 'goalTest'], [$m, 'successors'], $distance);
if (is_null($solution3)) {
  Output::out('Found no solution using A* with euclidian distance');
} else {
  $path3 = nodeToPath($solution3);
  $m->mark($path3);
  Output::out($m);
  $m->clear($path3);
}
Output::out('A* with Manhattan distance');
$distance = manhattanDistance($m->getGoal());
$solution4 = astar($m->getStart(), [$m, 'goalTest'], [$m, 'successors'], $distance);
if (is_null($solution4)) {
  Output::out('Found no solution using A* with Manhattan distance');
} else {
  $path4 = nodeToPath($solution4);
  $m->mark($path4);
  Output::out($m);
  $m->clear($path4);
}
