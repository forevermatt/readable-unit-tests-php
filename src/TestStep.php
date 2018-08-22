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
        $stepTextWords = explode(' ', $gherkinStep->getText());
        
        $functionName = strtolower($gherkinStep->getKeyword());
        $arguments = [];
        
        foreach ($stepTextWords as $word) {
            if (empty($word)) {
                continue;
            }
        
            if (is_numeric($word)) {
                $functionName .= 'Number';
                $arguments[] = $word + 0;
                continue;
            }
            
            $lowerCaseWord = strtolower($word);
            $alphaNumericWord = preg_replace('/[^A-Za-z0-9]/', '', $lowerCaseWord);
            $functionName .= ucfirst($alphaNumericWord);
        }
        
        $this->functionName = $functionName;
        $this->arguments = $arguments;
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
