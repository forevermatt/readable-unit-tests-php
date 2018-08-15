<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class Test
{
    /** @var File */
    private $fileToTest;
    
    /** @var TestSpecification */
    private $testSpecification;
    
    private $testImplementation;
    
    public function __construct(File $fileToTest)
    {
        $this->fileToTest = $fileToTest;
    }
    
    /**
     * Run the tests for the given File.
     *
     * @param File $fileToTest
     * @return string The result/output from having tried to run the test.
     */
    public static function testFile(File $fileToTest)
    {
        $test = new Test($fileToTest);
        return $test->run();
    }
    
    /**
     * Run this test.
     *
     * @return string The result/output.
     */
    public function run()
    {
        if (! $this->fileToTest->hasTestSpecification()) {
            return sprintf(
                'No test specification file found for %s. Expected path: %s',
                $this->fileToTest->getRelativePath(),
                $this->fileToTest->getPathToTestSpecification()
            );
        }
        
        if (! $this->fileToTest->hasTestImplementation()) {
            return sprintf(
                'No test implementation file found for %s. Expected path: %s',
                $this->fileToTest->getRelativePath(),
                $this->fileToTest->getPathToTestImplementation()
            );
        }
        
        $this->testSpecification = new TestSpecification(
            $this->fileToTest->getPathToTestSpecification()
        );
        
        $this->testImplementation = new TestImplementation(
            $this->fileToTest->getPathToTestImplementation()
        );
        
        return $this->runScenarios();
    }
    
    protected function runScenarios()
    {
        Assert::isInstanceOf($this->testSpecification, TestSpecification::class);
        Assert::isInstanceOf($this->testImplementation, TestImplementation::class);
        
        foreach ($this->testSpecification->getScenarios() as $scenario) {
            
            
            // TEMP
            return var_export($scenario, true);
            
        }
        
        
        
        
    }
}
