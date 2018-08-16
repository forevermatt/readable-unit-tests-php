Feature: Running tests

  Scenario: Simple example with all the necessary files
    Given a file at "./sample/Calculator.php"
      And a file at "./sample/test/Calculator.test"
      And a file at "./sample/test/CalculatorTest.php"
    When I run the tests in "./sample"
    Then the tests in "CalculatorTest" should have been be run
