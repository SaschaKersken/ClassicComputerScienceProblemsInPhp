<?php

require_once(__DIR__.'/generic_search.php');
require_once(__DIR__.'/../Output.php');

class Cell {
  const EMPTY = ' ';
  const BLOCKED = 'X';
  const START = 'S';
  const GOAL = 'G';
  const PATH = '*';
}

class MazeLocation {
  public $row = 0;
  public $column = 0;

  public function __construct($row, $column) {
    $this->row = $row;
    $this->column = $column;
  }
}

class Maze {
  private $rows = 10;
  private $columns = 10;
  private $sparseness = 0.2;
  private $start = NULL;
  private $goal = NULL;
  private $_grid = [];
  public $goalTest = NULL;
  public $successors = NULL;
  public $euclidianDistance = NULL;
  public $manhattanDistance = NULL;

  public function __construct($rows = 10, $columns = 10, $sparseness = 0.2, $start = NULL, $goal = NULL) {
    $this->rows = $rows;
    $this->columns = $columns;
    $this->sparseness = 0.2;
    $this->start = $start ? $start : new MazeLocation(0, 0);
    $this->goal = $goal ? $goal : new MazeLocation(9, 9);
    for ($i = 0; $i < $rows; $i++) {
      $this->_grid[$i] = [];
      for ($j = 0; $j < $columns; $j++) {
        $this->_grid[$i][$j] = Cell::EMPTY;
      }
    }
    $this->randomlyFill($rows, $columns, $sparseness);
    $this->_grid[$this->start->row][$this->start->column] = Cell::START;
    $this->_grid[$this->goal->row][$this->goal->column] = Cell::GOAL;

    $this->goalTest = function(MazeLocation $ml): bool {
      return $ml == $this->goal;
    };

    $this->successors = function(MazeLocation $ml): array {
      $locations = [];
      if ($ml->row + 1 < $this->rows && $this->_grid[$ml->row + 1][$ml->column] != Cell::BLOCKED) {
        $locations[] = new MazeLocation($ml->row + 1, $ml->column);
      }
      if ($ml->row -1 >= 0 && $this->_grid[$ml->row - 1][$ml->column] != Cell::BLOCKED) {
        $locations[] = new MazeLocation($ml->row - 1, $ml->column);
      }
      if ($ml->column + 1 < $this->columns && $this->_grid[$ml->row][$ml->column + 1] != Cell::BLOCKED) {
        $locations[] = new MazeLocation($ml->row, $ml->column + 1);
      }
      if ($ml->column - 1 >= 0 && $this->_grid[$ml->row][$ml->column - 1] != Cell::BLOCKED) {
        $locations[] = new MazeLocation($ml->row, $ml->column - 1);
      }
      return $locations;
    };
  }

  private function randomlyFill(int $rows, int $columns, float $sparseness) {
    for ($row = 0; $row < $rows; $row++) {
      for ($column = 0; $column < $columns; $column++) {
        if ((float)rand() / (float)getrandmax() < $sparseness) {
          $this->_grid[$row][$column] = Cell::BLOCKED;
        }
      }
    }
  }

  public function __toString() {
    $output = '';
    foreach ($this->_grid as $row) {
      $output .= implode('', $row)."\n";
    }
    return $output;
  }

  public function mark(array $path) {
    foreach ($path as $mazeLocation) {
      $this->_grid[$mazeLocation->row][$mazeLocation->column] = Cell::PATH;
    }
    $this->_grid[$this->start->row][$this->start->column] = Cell::START;
    $this->_grid[$this->goal->row][$this->goal->column] = Cell::GOAL;
  }

  public function clear(array $path) {
    foreach ($path as $mazeLocation) {
      $this->_grid[$mazeLocation->row][$mazeLocation->column] = Cell::EMPTY;
    }
    $this->_grid[$this->start->row][$this->start->column] = Cell::START;
    $this->_grid[$this->goal->row][$this->goal->column] = Cell::GOAL;
  }

  public function getStart() {
    return $this->start;
  }

  public function getGoal() {
    return $this->goal;
  }
}

function euclidianDistance(MazeLocation $goal) {
  return function(MazeLocation $ml) use($goal): float {
    $xdist = $ml->column - $goal->column;
    $ydist = $ml->row - $goal->row;
    return sqrt(($xdist * $xdist) + ($ydist * $ydist));
  };
}

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
$solution1 = dfs($m->getStart(), $m->goalTest, $m->successors);
if (is_null($solution1)) {
  Output::out('Found no solution using DFS');
} else {
  $path1 = nodeToPath($solution1);
  $m->mark($path1);
  Output::out($m);
  $m->clear($path1);
}
Output::out('Breadth-first search:');
$solution2 = bfs($m->getStart(), $m->goalTest, $m->successors);
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
$solution3 = astar($m->getStart(), $m->goalTest, $m->successors, $distance);
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
$solution4 = astar($m->getStart(), $m->goalTest, $m->successors, $distance);
if (is_null($solution4)) {
  Output::out('Found no solution using A* with Manhattan distance');
} else {
  $path4 = nodeToPath($solution4);
  $m->mark($path4);
  Output::out($m);
  $m->clear($path4);
}
