Feature: Running tests

  Scenario: Simple example with all the necessary files
    Given a file at "./sample/Calculator.php"
      And a file at "./sample/test/unit/Calculator.test"
      And a file at "./sample/test/unit/CalculatorTest.php"
    When I run the tests in "./sample"
    Then the tests in "CalculatorTest" should have been be run
