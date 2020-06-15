<?php

require_once(__DIR__.'/../../../Util.php');

use PHPUnit\Framework\TestCase;

final class NetworkUtilsTest extends TestCase {
  /**
  * @covers NetworkUtils::sigmoid
  */
  public function testSigmoid() {
    $this->assertEquals(0.5, NetworkUtils::sigmoid(0));
  }

  /**
  * @covers NetworkUtils::derivativeSigmoid
  */
  public function testDerivativeSigmoid() {
    $this->assertEquals(0.25, NetworkUtils::derivativeSigmoid(0));
  }

  /**
  * @covers NetworkUtils::normalizeByFeatureScaling
  */
  public function testNormalizeByFeatureScaling() {
    $this->assertEquals(
      [[0, 0], [1, 1]],
      NetworkUtils::normalizeByFeatureScaling([[10, 20], [100, 200]])
    );
  }

  /**
  * @covers NetworkUtils::dotProduct
  */
  public function testDotProduct() {
    $this->assertEquals(2, NetworkUtils::dotProduct([1, 1], [1, 1]));
  }
}
