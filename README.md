# Readable Unit Tests (PHP)
A Gherkin-based PHP unit-testing framework

## Install it
The easiest way to install Readable Unit Tests (PHP) is to use
[Composer](https://getcomposer.org/):

```
composer require --dev forevermatt/readable-unit-tests-php
```

## Try it out
If you clone this repo, you can use the following command to run the sample
tests:

```
php run-tests.php sample/src
```

## Generate skeleton test files
To generate basic/skeleton test specification and test implementation files, run
something like the following (replacing `sample/src` with the path to your
files):

```
php generate-test-files.php sample/src
```

## Goals

- Tests written in Gherkin (aka "plain English")
- The ability to **unit** test PHP
- One `.test` file per PHP file/class (containing Gherkin)
- One corresponding `...Test.php` file with the PHP implementation of those test
  steps

## Example folder/file structure

```
- sample
  - src/
    - Calculator.php (PHP class to be tested)
  - tests/
    - unit/
      - Calculator.test (Gherkin)
      - CalculatorTest.php (PHP implementation of test steps)
```
