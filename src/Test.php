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
            return 'No test file found for ' . $this->fileToTest->getRelativePath();
        }
        
        $this->testSpecification = new TestSpecification(
            $this->fileToTest->getPathToTestSpecification()
        );
        
        
        
        // TEMP
        die(var_dump($this->testSpecification));
        
        
        
    }
}
