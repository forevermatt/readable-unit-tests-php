<?php
namespace ReadableUnitTests;

use Psr\Log\LoggerInterface;
use Webmozart\Assert\Assert;

class Runner
{
    /** @var LoggerInterface */
    protected $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function runTests(string $pathToFolder)
    {
        try {
            Assert::notEmpty($pathToFolder, 'Please specify a folder with code to test');
            $folder = new Folder($pathToFolder);
            foreach ($folder->getFilesToTest() as $fileToTest) {
                Test::testFile($fileToTest, $this->logger);
            }
            $this->logger->notice('Result: OK');
            return 0;
        } catch (\Throwable $t) {
            $this->logger->error('ERROR: ' . $t->getMessage());
            $this->logger->error('Result: FAIL');
            return 1;
        }
    }
}
