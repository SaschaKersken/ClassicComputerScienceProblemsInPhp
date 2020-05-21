<?php

require_once(__DIR__.'/DataPoint.php');
require_once(__DIR__.'/../Output.php');

class Cluster {
  public $points = [];
  public $centroid = NULL;

  public function __construct(array $points, DataPoint $centroid) {
    $this->points = $points;
    $this->centroid = $centroid;
  }
}

class KMeans {
  protected $_points = [];
  protected $_clusters = [];

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

  public function mean($data) {
    if (count($data) == 0) {
      return 0;
    }
    return array_sum($data) / count($data);
  }

  public function stdev($data) {
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

  public function zscores(array $original): array {
    $avg = $this->mean($original);
    $std = $this->stdev($original);
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

  public function __get($property) {
    if ($property == 'centroids') {
      return array_map(
        function ($x) {
          return $x->centroid;
        },
        $this->_clusters
      );
    }
  }

  protected function _dimensionSlice(int $dimension): array {
    return array_map(
      function ($x) use($dimension) {
        return $x->dimensions[$dimension];
      },
      $this->_points
    );
  }

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

  protected function _randomPoint(): DataPoint {
    $randDimensions = [];
    for ($dimension = 0; $dimension < $this->_points[0]->numDimensions; $dimension++) {
      $values = $this->_dimensionSlice($dimension);
      $randValue = (float)rand() / getrandmax() * (max($values) - min($values)) + min($values);
      $randDimensions[] = $randValue;
    }
    return new DataPoint($randDimensions);
  }

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

  protected function _generateCentroids() {
    foreach ($this->_clusters as $cluster) {
      if (count($cluster->points) == 0) {
        continue;
      }
      $means = [];
      for ($dimension = 0; $dimension < $this->_points[0]->numDimensions; $dimension++) {
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
      foreach ($this->_clusters as $cluster) {
        $cluster->points = [];
      }
      $this->_assignClusters();
      $oldCentroids = array_map(
        function($centroid) {
          return clone $centroid;
        },
        $this->centroids
      );
      $this->_generateCentroids();
      if ($oldCentroids == $this->centroids) {
        Output::out("Converged after $iteration iterations");
        return $this->_clusters;
      }
    }
    return $this->_clusters;
  }
}
