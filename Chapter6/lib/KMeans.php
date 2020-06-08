<?php

require_once(__DIR__.'/../../Util.php');

/**
* KMeans class
*
* @package ClassicComputerScienceProblemsInPhp
* @property array $centroids The centroids of all clusters
*/
class KMeans {
  /**
  * Data points
  * @var array
  */
  protected $_points = [];

  /**
  * Clusters
  * @var array
  */
  protected $_clusters = [];

  /**
  * Constructor
  *
  * @param int $k Number of clusters to create
  * @param array $points The data points to place in the clusters
  * @throws InvalidArgumentException if $k < 1
  */
  public function __construct(int $k, array $points) {
    if ($k < 1) {
      throw new InvalidArgumentException('k must be >= 1');
    }
    $this->_points = $points;
    $this->_zscoreNormalize();
    for ($i = 0; $i < $k; $i++) {
      $randPoint = $this->_randomPoint();
      $cluster = new Cluster([], $randPoint);
      $this->_clusters[] = $cluster;
    }
  }

  /**
  * Statistics base function: mean
  *
  * @param array $data An array of floats
  * @return float The mean of the original values
  */
  public function mean(array $data): float {
    if (count($data) == 0) {
      return 0;
    }
    return array_sum($data) / count($data);
  }

  /**
  * Statistics base function: standard deviation
  *
  * @param array $data An array of floats
  * @return float The standard deviation of the original values
  */
  public function stdev(array $data): float {
    if (count($data) == 0) {
      return 0;
    }
    $mu = $this->mean($data);
    return sqrt(
      array_sum(
        array_map(
          function($x) use($mu) {
            return ($x - $mu) ** 2;
          },
          $data
        )
      ) / count($data)
    );
  }

  /**
  * Calculate z-scores
  *
  * @param array An array of floats to calculate z-scores for
  * @return array The z-scores for each original value
  */
  public function zscores(array $original): array {
    $avg = $this->mean($original);
    $std = $this->stdev($original);
    // Return all zeros if there is no variation
    if ($std == 0) {
      return array_fill(0, count($original), 0);
    }
    return array_map(
      function ($x) use ($avg, $std) {
        return ($x - $avg) / $std;
      },
      $original
    );
  }

  /**
  * Magic getter method
  *
  * @param string $property Property to get
  * @return mixed The property's value
  */
  public function __get(string $property) {
    if ($property == 'centroids') {
      return array_map(
        function ($x) {
          return $x->centroid;
        },
        $this->_clusters
      );
    }
  }

  /**
  * Get one dimension from all points
  *
  * @param int $dimension The dimension
  * @return array Data for this dimension
  */
  protected function _dimensionSlice(int $dimension): array {
    return array_map(
      function ($x) use($dimension) {
        return $x->dimensions[$dimension];
      },
      $this->_points
    );
  }

  /**
  * Feature-scale data
  *
  * Calculate the zcore of each feature in each dimension of each data point
  */
  protected function _zscoreNormalize() {
    $zscored = array_fill(0, count($this->_points), []);
    for ($dimension = 0; $dimension < $this->_points[0]->numDimensions; $dimension++) {
      $dimensionSlice = $this->_dimensionSlice($dimension);
      foreach ($this->zscores($dimensionSlice) as $index => $zscore) {
        $zscored[$index][] = $zscore;
      }
    }
    for ($i = 0; $i < count($this->_points); $i++) {
      $this->_points[$i]->dimensions = $zscored[$i];
    }
  }

  /**
  * Create a random data point as initial centroid
  *
  * @return DataPoint The generated data point
  */
  protected function _randomPoint(): DataPoint {
    $randDimensions = [];
    for ($dimension = 0; $dimension < $this->_points[0]->numDimensions;
        $dimension++) {
      $values = $this->_dimensionSlice($dimension);
      $randValue = (float)rand() /
        getrandmax() * (max($values) - min($values)) + min($values);
      $randDimensions[] = $randValue;
    }
    return new DataPoint($randDimensions);
  }

  /**
  * Assign points to clusters
  *
  * Find the closest cluster centroid to each point
  * and assign the point to that cluster
  */
  protected function _assignClusters() {
    foreach ($this->_points as $point) {
      $centroids = $this->centroids;
      usort(
        $centroids,
        function ($a, $b) use ($point) {
          return $point->distance($a) - $point->distance($b);
        }
      );
      $closest = $centroids[0];
      $idx = array_search($closest, $this->centroids);
      $cluster = $this->_clusters[$idx];
      $cluster->points[] = $point;
    }
  }

  /**
  * Generate centroids
  *
  * Find the center of each cluster and move the centroid to there
  */
  protected function _generateCentroids() {
    foreach ($this->_clusters as $cluster) {
      if (count($cluster->points) == 0) {
        continue;
      }
      $means = [];
      for ($dimension = 0; $dimension < $this->_points[0]->numDimensions;
          $dimension++) {
        $dimensionSlice = array_map(
          function ($p) use($dimension) {
            return $p->dimensions[$dimension];
          },
          $cluster->points
        );
        $means[] = $this->mean($dimensionSlice);
      }
      $cluster->centroid = new DataPoint($means);
    }
  }
 
  public function run($maxIterations = 100): array {
    for ($iteration = 0; $iteration < $maxIterations; $iteration++) {
      foreach ($this->_clusters as $cluster) { // Clear all clusters
        $cluster->points = [];
      }
      $this->_assignClusters(); // Find cluster each point is closest to
      $oldCentroids = array_map( // Record
        function($centroid) {
          return clone $centroid;
        },
        $this->centroids
      );
      $this->_generateCentroids(); // Find new centroids
      if ($oldCentroids == $this->centroids) { // Have centroids moved?
        Util::out("Converged after $iteration iterations");
        return $this->_clusters;
      }
    }
    return $this->_clusters;
  }
}
