<?php

use ReadableUnitTests\ReadableTest;
use ReadableUnitTests\StepParser;
use Webmozart\Assert\Assert;

class StepParserTest extends ReadableTest
{
    protected $stepKeyword;
    protected $stepText;
    
    protected $resultingFunctionName;
    protected $resultingArguments;
    
    public function givenAStepThatContainsAString()
    {
        $this->stepKeyword = 'Given';
        $this->stepText = 'the name "John"';
    }
    
    public function whenIParseThatStep()
    {
        $stepParser = new StepParser($this->stepKeyword, $this->stepText);
        $this->resultingFunctionName = $stepParser->getFunctionName();
        $this->resultingArguments = $stepParser->getArguments();
    }
    
    public function thenTheResultShouldHaveTheWordStringWhereThatStringWas()
    {
        $stepTextWithStringReplaced = preg_replace('/"[^"]*"/', 'String', $this->stepText);
        $stepTextPieces = explode(' ', $stepTextWithStringReplaced);
        
        $expectedFunctionName = strtolower($this->stepKeyword);
        foreach ($stepTextPieces as $stepTextPiece) {
            $expectedFunctionName .= ucfirst(strtolower($stepTextPiece));
        }
        
        Assert::same($this->resultingFunctionName, $expectedFunctionName);
    }
    
    public function andThatStringShouldBeInTheListOfArguments()
    {
        $matches = [];
        $pregMatchResult = preg_match('/"([^"]*)"/', $this->stepText, $matches);
        Assert::same($pregMatchResult, 1, 'Failed to find the string in the step text');
        Assert::true(
            in_array($matches[1], $this->resultingArguments, true),
            sprintf(
                'Failed to find that string (%s) in the list of arguments: %s',
                $matches[1],
                var_export($this->resultingArguments, true)
            )
        );
    }
}
