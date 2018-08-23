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
    
    public function getTestClassInstance(): ReadableTest
    {
        $this->loadFileToTest();
        $this->loadTestImplementationFile();
        $testClassName = $this->getTestClassName();
        return new $testClassName();
    }
    
    private function getTestClassName()
    {
        $pathToTestImplementation = $this->fileToTest->getPathToTestImplementation();
        $pathInfo = pathinfo($pathToTestImplementation);
        return $pathInfo['filename'];
    }
    
    private function loadFileToTest()
    {
        $pathToFile = $this->fileToTest->getPath();
        require_once $pathToFile;
    }
    
    private function loadTestImplementationFile()
    {
        $pathToTestImplementation = $this->fileToTest->getPathToTestImplementation();
        require_once $pathToTestImplementation;
    }
}
