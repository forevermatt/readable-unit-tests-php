<?php

use ReadableUnitTests\ReadableTest;
use Webmozart\Assert\Assert;

class CalculatorTest extends ReadableTest
{
    protected $result;

    public function whenIAddNumberAndNumber($firstNumber, $secondNumber)
    {
        $calculator = new Calculator();
        $this->result = $calculator->add($firstNumber, $secondNumber);
    }
    
    public function thenTheResultShouldBeNumber($number)
    {
        Assert::same($this->result, $number);
    }
}
