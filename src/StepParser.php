<?php
namespace ReadableUnitTests;

class StepParser
{
    /** @var string */
    protected $functionName;
    
    /** @var array */
    protected $arguments;
    
    public function __construct(string $stepKeyword, string $stepText)
    {
        $stepTextWords = explode(' ', $stepText);
        
        $functionName = strtolower($stepKeyword);
        $arguments = [];
        
        foreach ($stepTextWords as $word) {
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
