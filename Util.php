<?php

class Util {
  static $cli = NULL;

  static function init() {
    if (is_null(self::$cli)) {
      self::$cli = (php_sapi_name() === 'cli');
      if (self::$cli === FALSE) {
        echo '<pre>'.PHP_EOL;
      }
    }
  }

  static function autoload($className) {
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

  static function out($text, $suppressEol = FALSE) {
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

spl_autoload_register(['Util', 'autoload']);
