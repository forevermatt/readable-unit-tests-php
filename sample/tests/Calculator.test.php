<?php

use Webmozart\Assert\Assert;

class CalculatorTest
{
    protected $result;

    /**
     * @When I add :firstNumber and :secondNumber
     */
    public function whenIAdd($firstNumber, $secondNumber)
    {
        $calculator = new Calculator();
        $this->result = $calculator->add($firstNumber, $secondNumber);
    }

    /**
     * @Then the result should be :number
     */
    public function thenTheResultShouldBe($number)
    {
        Assert::same($this->result, $number);
    }
}