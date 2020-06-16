<?php

require_once(__DIR__.'/../../Autoloader.php');

/**
* Maze class
*
* Represents a maze, i.e. a grid of cells with various states
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Maze {
  /**
  * Randomizer instance to use
  * @var Randomizer
  */
  private $randomizer = NULL;

  /**
  * Number of rows
  * @var int
  */
  private $rows = 10;

  /**
  * Number of columns
  * @var int
  */
  private $columns = 10;

  /**
  * How sparsely the maze is to be filled with blocked cells
  * @var float
  */
  private $sparseness = 0.2;

  /**
  * Start location
  * @var MazeLocation
  */
  private $start = NULL;

  /**
  * Goal location
  * @var MazeLocation
  */
  private $goal = NULL;

  /**
  * Internal representation of the grid
  * @var array
  */
  private $_grid = [];

  /**
  * Constructor
  *
  * @param int $rows Number of rows optional, default 10
  * @param int $columns Number of columns optional, default 10
  * @param float $sparseness Probability for a cell to be blocked optional, default 0.2
  * @param MazeLocation $start Start location optional, default NULL
  * @param MazeLocation $goal Goal locationoptional, default NULL
  */
  public function __construct(int $rows = 10, int $columns = 10, float $sparseness = 0.2, MazeLocation $start = NULL, MazeLocation $goal = NULL) {
    $this->rows = $rows;
    $this->columns = $columns;
    $this->sparseness = 0.2;
    $this->start = $start ? $start : new MazeLocation(0, 0);
    $this->goal = $goal ? $goal : new MazeLocation(9, 9);
    // Fill the grid with empty cells
    for ($i = 0; $i < $rows; $i++) {
      $this->_grid[$i] = [];
      for ($j = 0; $j < $columns; $j++) {
        $this->_grid[$i][$j] = Cell::EMPTY;
      }
    }
    // Populate the grid with blocked cells
    $this->randomlyFill($rows, $columns, $sparseness);
    // Fill the start and goal locations in
    $this->_grid[$this->start->row][$this->start->column] = Cell::START;
    $this->_grid[$this->goal->row][$this->goal->column] = Cell::GOAL;
  }

  /**
  * Is a specific maze location the goal?
  *
  * @param MazeLocation $ml The maze location to test
  * @return bool TRUE if this is the goal, otherwise FALSE
  */
  public function goalTest(MazeLocation $ml): bool {
    return $ml == $this->goal;
  }

  /**
  * Find all possible successors of current location (non-blocked neighbors)
  *
  * @param MazeLocation $ml The maze location to find successors for
  * @return array The list of possible successors
  */
  public function successors(MazeLocation $ml): array {
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
  }

  /**
  * Randomly fill with blocked cells
  *
  * @param int $rows Number of rows
  * @param int $columns Number of columns
  * @param float $sparseness Probability for each cell to be blocked
  */
  protected function randomlyFill(int $rows, int $columns, float $sparseness) {
    for ($row = 0; $row < $rows; $row++) {
      for ($column = 0; $column < $columns; $column++) {
        if ($this->randomizer()->randomFloat() < $sparseness) {
          $this->_grid[$row][$column] = Cell::BLOCKED;
        }
      }
    }
  }

  /**
  * Return a nicely formatted version of the maze for printing
  *
  * @return string The string representation
  */
  public function __toString(): string {
    $output = '';
    foreach ($this->_grid as $row) {
      $output .= implode('', $row)."\n";
    }
    return $output;
  }

  /**
  * Mark a path in the maze
  *
  * @param array $path The maze locations that make up the path
  */
  public function mark(array $path) {
    foreach ($path as $mazeLocation) {
      $this->_grid[$mazeLocation->row][$mazeLocation->column] = Cell::PATH;
    }
    $this->_grid[$this->start->row][$this->start->column] = Cell::START;
    $this->_grid[$this->goal->row][$this->goal->column] = Cell::GOAL;
  }

  /**
  * Reset a path in the maze
  *
  * @param array $path The maze locations that make up the path
  */
  public function clear(array $path) {
    foreach ($path as $mazeLocation) {
      $this->_grid[$mazeLocation->row][$mazeLocation->column] = Cell::EMPTY;
    }
    $this->_grid[$this->start->row][$this->start->column] = Cell::START;
    $this->_grid[$this->goal->row][$this->goal->column] = Cell::GOAL;
  }

  /**
  * Get the start location
  *
  * @return MazeLocation The start location
  */
  public function getStart(): MazeLocation {
    return $this->start;
  }

  /**
  * Get the goal location
  *
  * @return MazeLocation The goal location
  */
  public function getGoal() {
    return $this->goal;
  }

  /**
  * Get/set the Randomizer instance to use
  *
  * @param Randomizer $randomizer Object to inject optional, default NULL
  * @return Randomizer The injected, new, or previously initialized Randomizer
  */
  public function randomizer(Randomizer $randomizer = NULL): Randomizer {
    if (!is_null($randomizer)) {
      $this->randomizer = $randomizer;
    } elseif (is_null($this->randomizer)) {
      $this->randomizer = new Randomizer();
    }
    return $this->randomizer;
  }
}
