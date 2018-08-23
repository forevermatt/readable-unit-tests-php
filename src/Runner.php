<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class Runner
{
    public function runTests(string $pathToFolder)
    {
        $output = [];
        try {
            Assert::notEmpty($pathToFolder, 'Please specify a folder with code to test');
            $folder = new Folder($pathToFolder);
            foreach ($folder->getFilesToTest() as $fileToTest) {
                $output[] = Test::testFile($fileToTest);
            }
        } catch (\Throwable $t) {
            $output[] = 'ERROR: ' . $t->getMessage();
        }
        return PHP_EOL . join(PHP_EOL, $output) . PHP_EOL;
    }
}
