<?php

/**
* Build the cartesian product of an arbitrary number of arrays
*
* Gratefully borrowed from https://stackoverflow.com/a/6313346
*
* @param array $input An array of arrays
* @return array The cartedian product of the input arrays
*/
function cartesian(array $input): array {
  $result = [];
  foreach ($input as $key => $values) {
    if (empty($values)) {
      continue;
    }
    if (empty($result)) {
      foreach($values as $value) {
        $result[] = [$key => $value];
      }
    }
    else {
      $append = [];
      foreach($result as &$product) {
        $product[$key] = array_shift($values);
        $copy = $product;
        foreach($values as $item) {
          $copy[$key] = $item;
          $append[] = $copy;
        }
        array_unshift($values, $product[$key]);
      }
      $result = array_merge($result, $append);
    }
  }
  return $result;
}

/**
* Return all possible mnemonics for a specific phone number
*
* @param string $phoneNumber The phone number to create mnemonics for
* @return array All possible mnemonics
*/
function possibleMnemonics(string $phoneNumber): array {
  $phoneMapping = [
    '1' => ['1'],
    '2' => ['a', 'b', 'c'],
    '3' => ['d', 'e', 'f'],
    '4' => ['g', 'h', 'i'],
    '5' => ['j', 'k', 'l'],
    '6' => ['m', 'n', 'o'],
    '7' => ['p', 'q', 'r', 's'],
    '8' => ['t', 'u', 'v'],
    '9' => ['w', 'x', 'y', 'z'],
    '0' => ['0']
  ];
  $letterTuples = [];
  foreach (str_split($phoneNumber) as $digit) {
    if (preg_match('(\D)', $digit)) {
      continue;
    }
    $letterTuples[] = $phoneMapping[$digit];
  }
  $result = [];
  if (!empty($letterTuples)) {
    $result = cartesian($letterTuples);
  }
  return $result;
}
