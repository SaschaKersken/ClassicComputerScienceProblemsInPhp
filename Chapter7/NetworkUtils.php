<?php

/**
* NetworkUtils class
*
* Helper class that holds some static methods for neural networks
*
* @package ClassicComputerScienceProblemsInPhp
*/
class NetworkUtils {
  /**
   * Sigmoid function
   *
   *                 1
   * sigmoid(x) = -------
   *                 x-1
   *                e
   *
   * @param float $x Value to calculate the sigmoid function for
   * @return float Sigmoid of input value
   */
  public static function sigmoid(float $x): float {
    return 1 / (1 + exp(-$x));
  }

  /**
   * Derivation of the sigmoid function
   *
   * f(x) = sigmoid(x)
   * f'(x) = sigmoid(x) * (1 - sigmoid(x))
   *
   * @param float $x Value to calculate the derivative sigmoid function for
   * @return float Derivative sigmoid function of input value
   */
  public static function derivativeSigmoid(float $x): float {
    return NetworkUtils::sigmoid($x) * (1 - NetworkUtils::sigmoid($x));
  }

  /**
  * Feature-scale a set of values
  *
  * Make sure that all values come close to -1 < value < 1
  *
  * @param array $dataset Data set to feature-scale
  * @return array Feature-scaled values
  */
  public static function normalizeByFeatureScaling(array $dataset): array {
    $result = [];
    for ($colNum = 0; $colNum < count($dataset[0]); $colNum++) {
      $column = array_map(
        function ($row) use($colNum) {
          return $row[$colNum];
        },
        $dataset
      );
      $maximum = max($column);
      $minimum = min($column);
      for ($rowNum = 0; $rowNum < count($dataset); $rowNum++) {
        $result[$rowNum][$colNum] =
          ($dataset[$rowNum][$colNum] - $minimum) / ($maximum - $minimum);
      }
    }
    return $result;
  }

  /**
   * Dot product of two vectors (i.e. one-dimensional arrays)
   *
   * @param array $vector1 Array of floats
   * @param array $vector2 Array of floats, must match $vector1 in numer of elements
   * @return float
   */
  public static function dotProduct($vector1, $vector2) {
    return array_sum(
      array_map(
        function($value, $index) use($vector2) {
          return $value * $vector2[$index];
        },
        $vector1,
        array_keys($vector1)
      )
    );
  }
}
