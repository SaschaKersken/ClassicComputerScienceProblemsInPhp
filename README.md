# Classic Computer Science Problems in Php
PHP ports of the examples in David Kopec's book "Classic Computer Science Problems in Python"
You can download the original Python examples from [David's repository](https://github.com/davecom/ClassicComputerScienceProblemsInPython).

## Requirements
* PHP 7.2 or newer to run the examples
* PHP 7.3 or newer to run the unit tests

## Unit Tests
This project contains PHPUnit unit tests for most of the PHP classes. In order to run them, perform the following steps:
1. Make sure you have the latest version of [Composer](https://getcomposer.org/)
2. In the project's main directory, run `composer install`
3. Change to the `tests` subdirectory: `cd tests`
4. Run all tests: `../vendor/phpunit/bin/phpunit .`
