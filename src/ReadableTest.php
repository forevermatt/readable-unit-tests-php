<?php
namespace ReadableUnitTests;

use Behat\Gherkin\Node\StepNode;

class ReadableTest
{
    public function runFunctionFor(StepNode $step)
    {
        $functionName = $this->getFunctionNameFor($step);
        $this->$functionName();
    }
    
    private function getFunctionNameFor(StepNode $step)
    {
        $rawStepWords = $step->getKeyword() . ' ' . $step->getText();
        $lowercased = strtolower($rawStepWords);
        $firstLettersUpper = ucwords($lowercased);
        $alphaNumeric = preg_replace('/[^A-Za-z0-9]/', '', $firstLettersUpper);
        return lcfirst($alphaNumeric);
    }
}
