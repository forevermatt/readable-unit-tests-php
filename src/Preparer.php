<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class Preparer
{
    public function generateMissingTestFilesFor(string $pathToFolder)
    {
        $output = [];
        try {
            Assert::notEmpty($pathToFolder, 'Please specify a folder with code to generate test files for');
            $folder = new Folder($pathToFolder);
            foreach ($folder->getFilesToTest() as $fileToTest) {
                $output[] = Test::generateTestFilesFor($fileToTest);
            }
        } catch (\Throwable $t) {
            $output[] = 'ERROR: ' . $t->getMessage();
        }
        return PHP_EOL . join(PHP_EOL, $output) . PHP_EOL;
    }
}
