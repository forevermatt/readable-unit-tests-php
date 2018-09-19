<?php
namespace ReadableUnitTests;

use Behat\Gherkin\Node\StepNode;

class TestStep
{
    /** @var string */
    protected $functionName;
    
    /** @var array */
    protected $arguments;
    
    public function __construct(StepNode $gherkinStep)
    {
        $stepParser = new StepParser($gherkinStep->getKeyword(), $gherkinStep->getText());
        
        $this->functionName = $stepParser->getFunctionName();
        $this->arguments = $stepParser->getArguments();
    }
    
    public function getFunctionName()
    {
        return $this->functionName;
    }
    
    public function getArguments()
    {
        return $this->arguments;
    }
}
