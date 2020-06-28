# Classic Computer Science Problems in PHP
PHP ports of the examples in David Kopec's book "Classic Computer Science Problems in Python"
You can download the original Python examples from [David's repository](https://github.com/davecom/ClassicComputerScienceProblemsInPython).

## Requirements
* PHP 7.2 or newer to run the examples
* PHP 7.3 or newer to run the unit tests

## Running the Examples
All examples have been designed to be used both on the command line interface (CLI) and in a web browser (served by a web server running the required PHP version).

In order to run the examples on CLI, just cd into the Chapter{n} directories and type `php filename`. Make sure to use the _cli_ and not the _web_ files for chapters 8 and 9.

If you want to run the web examples, make sure that the complete example directory is availabe via web server, and then point your browser to `http://{your-website/examples-folder}/index.html`.

## Unit Tests
This project contains PHPUnit unit tests for most of the PHP classes. In order to run them, perform the following steps:
1. Make sure you have the latest version of [Composer](https://getcomposer.org/)
2. In the project's main directory, run `composer install`
3. Change to the `tests` subdirectory: `cd tests`
4. Run all tests: `../vendor/phpunit/bin/phpunit .`
