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
}
