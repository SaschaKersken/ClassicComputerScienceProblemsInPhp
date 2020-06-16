<?php

/**
* Autoloader class to be used throughout the examples
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Autoloader {
  /**
  * Autoloader method for all classes in the examples
  *
  * @param string $className The class to load
  * @throws UnexpectedValueException if a class does not exist
  */
  public static function autoload($className) {
    if (!class_exists($className)) {
      $iterator = new RecursiveDirectoryIterator(__DIR__);
      foreach (new RecursiveIteratorIterator($iterator) as $entry) {
        if ($entry->getFilename() == $className.'.php') {
          require_once($entry->getPathname());
          return;
        }
      }
      throw new UnexpectedValueException("Class $className not found.");
    }
  }
}

// Register the autoloader method
spl_autoload_register(['Autoloader', 'autoload']);
