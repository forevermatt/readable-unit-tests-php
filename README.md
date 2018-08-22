# Readable Unit Tests (PHP)
A Gherkin-based PHP unit-testing framework

## Try it out
The following command will run the sample tests:

```
php run-tests.php sample
```

## Goals

- Tests written in Gherkin (aka "plain English")
- The ability to **unit** test PHP
- One `.test` file per PHP file/class (containing Gherkin)
- One corresponding `...Test.php` file with the PHP implementation of those test
  steps

## Example folder/file structure

```
- project
  - Calculator.php (PHP class to be tested)
  - tests/
    - unit/
      - Calculator.test (Gherkin)
      - CalculatorTest.php (PHP implementation of test steps)
```
