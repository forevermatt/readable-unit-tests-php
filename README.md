# Readable Unit Tests (PHP)
A Gherkin-based PHP unit-testing framework

## Goals

- Tests written in Gherkin (aka "plain English")
- The ability to **unit** test PHP
- One `.test` file per PHP file/class (containing Gherkin)
- One corresponding `.test.php` file with the PHP implementation of those test
  steps

## Example folder/file structure

```
- project
  - models
    - Calculator.php
  - tests
    - models
      - Calculator.test (Gherkin)
      - Calculator.test.php (PHP implementation of test steps)
```
