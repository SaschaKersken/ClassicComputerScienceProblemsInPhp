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

    static function out($text) {
        self::init();
        echo $text.PHP_EOL;
    }
}
