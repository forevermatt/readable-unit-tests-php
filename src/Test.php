<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class Test
{
    /** @var File */
    private $fileToTest;
    
    /** @var TestSpecification */
    private $testSpecification;
    
    /** @var TestImplementation */
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
        $this->testSpecification = new TestSpecification($this->fileToTest);
        $this->testImplementation = new TestImplementation($this->fileToTest);
        
        return $this->runScenarios();
    }
    
    protected function runScenarios()
    {
        Assert::isInstanceOf($this->testSpecification, TestSpecification::class);
        Assert::isInstanceOf($this->testImplementation, TestImplementation::class);
        
        $testClass = $this->testImplementation->getTestClassInstance();
        $scenarios = $this->testSpecification->getScenarios();
        $output = [];
        
        try {
            Assert::notEmpty(
                $scenarios,
                'No test scenarios found for ' . $this->fileToTest->getPhpFullClassPath()
            );
    
            foreach ($scenarios as $scenario) {
        
                $output[] = 'Scenario: ' . $scenario->getTitle();
                foreach ($scenario->getSteps() as $step) {
            
                    $output[] = '  ' . $step->getKeyword() . ' ' . $step->getText();
                    $testClass->runFunctionFor($step);
                }
            }
            $output[] = PHP_EOL . 'Result: OK';
            
        } catch (\Throwable $t) {
            $output[] = PHP_EOL . 'ERROR: ' . $t->getMessage() . PHP_EOL;
            $output[] = 'Result: FAIL';
        }
        
        return join(PHP_EOL, $output);
    }
    
    /**
     * Ensure the test-related files exist for the given File.
     *
     * @param File $fileToTest
     * @return string The result/output from having tried to do so.
     */
    public static function generateTestFilesFor(File $fileToTest)
    {
        $output = [];
        $output[] = TestSpecification::createFor($fileToTest);
        $output[] = TestImplementation::createFor($fileToTest);
        return join(PHP_EOL, $output);
    }
}
