<?php
namespace ReadableUnitTests;

use Behat\Gherkin\Node\FeatureNode;
use Webmozart\Assert\Assert;

class TestImplementation extends TestFile
{
    /** @var File */
    private $fileToTest;
    
    public function __construct(File $fileToTest)
    {
        $this->fileToTest = $fileToTest;
    
        $path = $fileToTest->getPathToTestImplementation();
        self::assertTestFileExists($path);
    }
    
    public static function createFor(File $fileToTest)
    {
        $pathToTestImplementation = $fileToTest->getPathToTestImplementation();
        
        if (file_exists($pathToTestImplementation)) {
            return sprintf('  "' . $pathToTestImplementation . '" already exists.');
        }
        
        $fileContents = self::createImplementationContentsFor($fileToTest);
        File::createAt($pathToTestImplementation, $fileContents);
        return '+ "' . $pathToTestImplementation . '" created.';
    }
    
    public static function createImplementationContentsFor(File $fileToTest)
    {
        return str_replace(
            'ClassName',
            $fileToTest->getPhpClassName() . 'Test',
            file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'implementation-template.txt')
        );
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
