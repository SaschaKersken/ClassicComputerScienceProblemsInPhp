<?php

use PHPUnit\Framework\TestCase;

final class MazeTest extends TestCase {
  /**
  * @covers Maze::__construct
  */
  public function testConstruct() {
    $maze = new Maze();
    $this->assertInstanceOf('Maze', $maze);
  }

  /**
  * @covers Maze::goalTest
  */
  public function testGoalTest() {
    $goal = new MazeLocation(10, 10);
    $maze = new Maze(10, 10, 0.2, new MazeLocation(0, 0), $goal);
    $this->assertTrue($maze->goalTest($goal));
  }

  /**
  * @covers Maze::successors
  */
  public function testSuccessors() {
    $maze = new Maze(3, 3, 0);
    $successors = [
      new MazeLocation(2, 1),
      new MazeLocation(0, 1),
      new MazeLocation(1, 2),
      new MazeLocation(1, 0)
    ];
    $this->assertEquals(
      $successors,
      $maze->successors(new MazeLocation(1, 1))
    );
  }

  /**
  * @covers Maze::randomlyFill
  */
  public function testRandomlyFill() {
    $randomizer = $this
      ->getMockBuilder('Randomizer')
      ->getMock();
    $randomizer
      ->expects($this->exactly(9))
      ->method('randomFloat')
      ->will($this->onConsecutiveCalls(1, 0, 1, 0, 1, 0, 1, 0, 1));
    $maze = new Maze_TestProxy(
      3,
      3,
      0,
      new MazeLocation(0, 0),
      new MazeLocation(2, 2)
    );
    $maze->randomizer($randomizer);
    $maze->randomlyFill(3, 3, 0.5);
    $this->assertEquals("SX \nX X\n XG\n", $maze->__toString());
  }

  /**
  * @covers Maze::__toString
  */
  public function testToString() {
    $maze = new Maze(3, 3, 0, new MazeLocation(0, 0), new MazeLocation(2, 2));
    $this->assertEquals("S  \n   \n  G\n", $maze->__toString());
  }

  /**
  * @covers Maze::mark
  */
  public function testMark() {
    $maze = new Maze(3, 3, 0, new MazeLocation(0, 0), new MazeLocation(2, 2));
    $pathSource = [[0, 0], [1, 0], [2, 0], [2, 1], [2, 2]];
    $path = [];
    foreach ($pathSource as $coords) {
      $path[] = new MazeLocation($coords[0], $coords[1]);
    }
    $maze->mark($path);
    $this->assertEquals("S  \n*  \n**G\n", $maze->__toString());
  }

  /**
  * @covers Maze::clear
  */
  public function testClear() {
    $maze = new Maze(3, 3, 0, new MazeLocation(0, 0), new MazeLocation(2, 2));
    $path = [new MazeLocation(1, 1)];
    $maze->mark($path);
    $maze->clear($path);
    $this->assertEquals("S  \n   \n  G\n", $maze->__toString());
  }

  /**
  * @covers Maze::getStart
  */
  public function testGetStart() {
    $start = new MazeLocation(0, 0);
    $maze = new Maze(3, 3, 0, $start, new MazeLocation(2, 2));
    $this->assertSame($start, $maze->getStart());
  }

  /**
  * @covers Maze::getGoal
  */
  public function testGetGoal() {
    $goal = new MazeLocation(2, 2);
    $maze = new Maze(3, 3, 0, new MazeLocation(0, 0), $goal);
    $this->assertSame($goal, $maze->getGoal());
  }

  /**
  * @covers Maze::randomizer
  */
  public function testRandomizerSet() {
    $randomizer = $this
      ->getMockBuilder('Randomizer')
      ->getMock();
    $maze = new Maze(3, 3, 0, new MazeLocation(0, 0), new MazeLocation(2, 2));
    $this->assertSame($randomizer, $maze->randomizer($randomizer));
  }

  /**
  * @covers Maze::randomizer
  */
  public function testRandomizerInit() {
    $maze = new Maze(3, 3, 0, new MazeLocation(0, 0), new MazeLocation(2, 2));
    $this->assertInstanceOf('Randomizer', $maze->randomizer());
  }
}

class Maze_TestProxy extends Maze {
  public function randomlyFill(int $rows, int $columns, float $sparseness) {
    parent::randomlyFill($rows, $columns, $sparseness);
  }
}
