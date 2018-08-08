<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class Test
{
    private $fileToTest;
    private $testSpecification;
    private $testImplementation;

    public function __construct(File $fileToTest)
    {
        $this->fileToTest = $fileToTest;
    }

    public static function testFile(File $fileToTest)
    {
        $test = new Test($fileToTest);
        $test->run();
    }

    public function run()
    {
        echo $this->fileToTest . PHP_EOL; // TEMP
    }
}
