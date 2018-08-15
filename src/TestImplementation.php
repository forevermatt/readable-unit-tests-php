<?php
namespace ReadableUnitTests;

use Behat\Gherkin\Node\FeatureNode;
use Webmozart\Assert\Assert;

class TestImplementation
{
    /** @var File */
    private $fileToTest;
    
    public function __construct(File $fileToTest)
    {
        $this->fileToTest = $fileToTest;
    
        $path = $fileToTest->getPathToTestImplementation();
        Assert::fileExists($path);
    }
}
