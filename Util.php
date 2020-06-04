<?php

/**
* Utility class to be used throughout the examples
*
* @package ClassicComputerScienceProblemsInPhp
*/
class Util {
  /**
  * Are we using CLI? NULL until we know, then TRUE or FALSE
  * @var boolean
  */
  static $cli = NULL;

  /**
  * Initialize: check whether we're using CLI, and if so, prepend <pre>
  */
  private static function init() {
    if (is_null(self::$cli)) {
      self::$cli = (php_sapi_name() === 'cli');
      if (self::$cli === FALSE) {
        echo '<pre>'.PHP_EOL;
      }
    }
  }

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

  /**
  * Output data
  *
  * @param mixed $text The data to print
  * @param bool $suppressEol If TRUE, omit line break; optional, default FALSE
  */
  public static function out($text, $suppressEol = FALSE) {
    self::init();
    if (is_string($text)) {
      echo $text.($suppressEol ? '' : PHP_EOL);
    } elseif (is_object($text) && method_exists($text, '__toString')) {
      echo $text.($suppressEol ? '' : PHP_EOL);
    } else {
      print_r($text);
      echo $suppressEol ? '' : PHP_EOL;
    }
  }
}

// Register the autoloader method
spl_autoload_register(['Util', 'autoload']);
