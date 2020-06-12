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
}

class KMeans_TestProxy extends KMeans {
  public function _dimensionSlice(int $dimension): array {
    return parent::_dimensionSlice($dimension);
  }

  public function _zcorseNormalize() {
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
}
