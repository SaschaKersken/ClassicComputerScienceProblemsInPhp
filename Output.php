<?php

class Output {
    static $cli = NULL;

    static function init() {
        if (is_null(self::$cli)) {
            self::$cli = (php_sapi_name() === 'cli');
            if (self::$cli === FALSE) {
                echo '<pre>'.PHP_EOL;
            }
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
