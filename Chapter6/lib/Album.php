<?php

require_once(__DIR__.'/../../Util.php');

/**
* Album class
*
* Two-dimensional data point representing a music album
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Album extends DataPoint {
  /**
  * Name of the album
  * @var string
  */
  private $name = '';

  /**
  * Release year of the album
  * @var int
  */
  private $year = 0;

  /**
  * Length of the album in minutes
  * @var float
  */
  private $length = 0.0;

  /**
  * Number of tracks on the album
  * @var float
  */
  private $tracks = 0.0;

  /**
  * Constructor
  *
  * @param string $name The album's name
  * @param int $year The album's release year
  * @param float $length The album's length in minutes
  * @param float $tracks The album's number of tracks
  */
  public function __construct(string $name, int $year, float $length, float $tracks) {
    parent::__construct([$length, $tracks]);
    $this->name = $name;
    $this->year = $year;
    $this->length = $length;
    $this->tracks = $tracks;
  }

  /**
  * Get string representation
  *
  * @return string The string representation
  */
  public function __toString(): string {
    return sprintf('%s, %d', $this->name, $this->year);
  }
}
