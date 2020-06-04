<?php

require_once(__DIR__.'/../Util.php');

/**
* Cluster class
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Cluster {
  /**
  * The data points in this cluster
  * @var array
  */
  public $points = [];

  /**
  * This cluster's centroid
  * @var DataPoint
  */
  public $centroid = NULL;

  /**
  * Constructor
  *
  * @param array $points Initial data points for this cluster
  * @param DataPoint $centroid
  */
  public function __construct(array $points, DataPoint $centroid) {
    $this->points = $points;
    $this->centroid = $centroid;
  }
}
