<?php
namespace ReadableUnitTests;

use Psr\Log\LoggerInterface;
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
    public static function testFile(File $fileToTest, LoggerInterface $logger)
    {
        $test = new Test($fileToTest);
        return $test->run($logger);
    }
    
    /**
     * Run this test.
     *
     * @param LoggerInterface $logger
     */
    public function run(LoggerInterface $logger)
    {
        try {
            $this->testSpecification = new TestSpecification($this->fileToTest);
            $this->testImplementation = new TestImplementation($this->fileToTest);
    
            $this->runScenarios($logger);
        } catch (MissingTestFileException $e) {
            $logger->warning('WARNING: ' . $e->getMessage());
        }
    }
    
    protected function runScenarios(LoggerInterface $logger)
    {
        Assert::isInstanceOf($this->testSpecification, TestSpecification::class);
        Assert::isInstanceOf($this->testImplementation, TestImplementation::class);
        
        $testClass = $this->testImplementation->getTestClassInstance();
        $scenarios = $this->testSpecification->getScenarios();
        
        Assert::notEmpty(
            $scenarios,
            'No test scenarios found for ' . $this->fileToTest->getPhpFullClassPath()
        );
        
        foreach ($scenarios as $scenario) {
            
            $logger->info('Scenario: ' . $scenario->getTitle());
            foreach ($scenario->getSteps() as $step) {
                
                $logger->info('  ' . $step->getKeyword() . ' ' . $step->getText());
                $testClass->runFunctionFor($step);
            }
        }
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
