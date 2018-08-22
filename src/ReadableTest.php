<?php
namespace ReadableUnitTests;

use Behat\Gherkin\Node\StepNode;
use Webmozart\Assert\Assert;

class ReadableTest
{
    public function runFunctionFor(StepNode $gherkinStep)
    {
        $testStep = new TestStep($gherkinStep);
        $functionName = $testStep->getFunctionName();
        $arguments = $testStep->getArguments();
        
        Assert::methodExists($this, $functionName, sprintf(
            'Expected the %s class to have a method called "%s"',
            get_class($this),
            $functionName
        ));
        
        Assert::notSame(false, call_user_func_array([$this, $functionName], $arguments), sprintf(
            'Something went wrong when calling %s\'s "%s" method',
            get_class($this),
            $functionName
        ));
    }
}
