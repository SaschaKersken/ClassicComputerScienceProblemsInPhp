<?php

require_once(__DIR__.'/../../../Util.php');

use \PHPUnit\Framework\TestCase;

final class KMeansTest extends TestCase {
  /**
  * @covers KMeans::__construct
  */
  public function testConstruct() {
    $kMeans = new KMeans(2, [new DataPoint([1, 2]), new DataPoint([3, 4])]);
    $this->assertInstanceOf('KMeans', $kMeans);
  }

  /**
  * @covers KMeans::__construct
  */
  public function testConstructExpectingException() {
    try {
      $kMeans = new KMeans(0, []);
      $this->fail('Expected InvalidArgumentException not thrown.');
    } catch(InvalidArgumentException$e) {
      $this->assertEquals('k must be >= 1', $e->getMessage());
    }
  }

  /**
  * @covers KMeans::mean
  * @dataProvider meanProvider
  */
  public function testMean($data, $expected) {
    $kMeans = new KMeans(2, [new DataPoint([1, 2]), new DataPoint([3, 4])]);
    $this->assertEquals($expected, $kMeans->mean($data));
  }

  public function meanProvider() {
    return [
      [[1, 2, 3], 2],
      [[], 0]
    ];
  }

  /**
  * @covers KMeans::stdev
  * @dataProvider stdevProvider
  */
  public function testStdev($data, $expected) {
    $kMeans = new KMeans(2, [new DataPoint([1, 2]), new DataPoint([3, 4])]);
    $this->assertEquals($expected, $kMeans->stdev($data));
  }

  public function stdevProvider() {
    return [
      [[1, 1, 1], 0],
      [[], 0]
    ];
  }

  /**
  * @covers KMeans::zscores
  * @dataProvider zscoresProvider
  */
  public function testZscores($data, $expected) {
    $kMeans = new KMeans(2, [new DataPoint([1, 2]), new DataPoint([3, 4])]);
    $this->assertEquals($expected, $kMeans->zscores($data));
  }

  public function zscoresProvider() {
    return [
      [[1, 2], [-1, 1]],
      [[1, 1, 1], [0, 0, 0]]
    ];
  }

  /**
  * @covers KMeans::__get
  */
  public function testGet() {
    $kMeans = new KMeans(2, [new DataPoint([1, 2]), new DataPoint([3, 4])]);
    $this->assertEquals(2, count($kMeans->centroids));
  }

  /**
  * @covers KMeans::__get
  */
  public function testGetUnknownProperty() {
    $kMeans = new KMeans(2, [new DataPoint([1, 2]), new DataPoint([3, 4])]);
    $this->assertNull($kMeans->unknownProperty);
  }

  /**
  * @covers KMeans::_dimensionSlice
  */
  public function testDimensionSlice() {
    $kMeans = new KMeans_TestProxy(2, [new DataPoint([1, 2]), new DataPoint([3, 4])]);
    $this->assertEquals([-1, 1], $kMeans->_dimensionSlice(0));
  }

  /**
  * @covers KMeans::_zscoreNormalize
  */
  public function testZscoreNormalize() {
    $kMeans = new KMeans_TestProxy(2, [new DataPoint([1, 2]), new DataPoint([3, 4])]);
    $kMeans->_zscoreNormalize();
    $points = $kMeans->_getPoints();
    $this->assertEquals(
      [[-1, -1], [1, 1]],
      [$points[0]->dimensions, $points[1]->dimensions]
    );
  }

  /**
  * @covers KMeans::_randomPoint
  */
  public function testRandomPoint() {
    $kMeans = new KMeans_TestProxy(2, [new DataPoint([1, 2]), new DataPoint([3, 4])]);
    $dimensions = $kMeans->_randomPoint()->dimensions;
    $this->assertGreaterThanOrEqual(-1, $dimensions[0]);
    $this->assertGreaterThanOrEqual(-1, $dimensions[1]);
    $this->assertLessThanOrEqual(1, $dimensions[0]);
    $this->assertLessThanOrEqual(1, $dimensions[1]);
  }

  /**
  * @covers KMeans::_assignClusters
  */
  public function testAssignClusters() {
    $points =  [new DataPoint([1, 2]), new DataPoint([3, 4])];
    $kMeans = new KMeans_TestProxy(1, $points);
    $kMeans->_assignClusters();
    $clusters = $kMeans->_getClusters();
    $this->assertEquals($points, $clusters[0]->points);
  }

  /**
  * @covers KMeans::_generateCentroids
  * @dataProvider generateCentroidsProvider
  */
  public function testGenerateCentroids($assignClusters) {
    $point = new DataPoint([1, 2]);
    $kMeans = new KMeans_TestProxy(1, [$point]);
    if ($assignClusters) {
      $kMeans->_assignClusters();
    }
    $kMeans->_generateCentroids();
    $clusters = $kMeans->_getClusters();
    $this->assertEquals($clusters[0]->centroid->dimensions, $point->dimensions);
  }

  public function generateCentroidsProvider() {
    return [
      [FALSE],
      [TRUE]
    ];
  }

  /**
  * @covers KMeans::run
  */
  public function testRunConvergence() {
    $point = new DataPoint([1, 2]);
    $kMeans = new KMeans(1, [$point]);
    $clusters = $kMeans->run();
    $this->assertEquals($point, $clusters[0]->points[0]);
  }

  /**
  * @covers KMeans::run
  */
  public function testRunNoConvergence() {
    $points = [new DataPoint([1, 2]), new DataPoint([3, 4])];
    $kMeans = new KMeans(1, $points);
    $clusters = $kMeans->run(1);
    $this->assertEquals($points, $clusters[0]->points);
  }
}

class KMeans_TestProxy extends KMeans {
  public function _dimensionSlice(int $dimension): array {
    return parent::_dimensionSlice($dimension);
  }

  public function _zscoreNormalize() {
    parent::_zscoreNormalize();
  }

  public function _randomPoint(): DataPoint {
    return parent::_randomPoint();
  }

  public function _assignClusters() {
    parent::_assignClusters();
  }

  public function _generateCentroids() {
    parent::_generateCentroids();
  }

  // Helper methods to get protected property values for testing
  public function _getPoints() {
    return $this->_points;
  }

  public function _getClusters() {
    return $this->_clusters;
  }
}
