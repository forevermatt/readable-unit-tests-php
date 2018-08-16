<?php
namespace ReadableUnitTests;

class Runner
{
    public function runTests(string $pathToFolder)
    {
        $output = [];
        $folder = new Folder($pathToFolder);
        foreach ($folder->getFilesToTest() as $fileToTest) {
            $output[] = Test::testFile($fileToTest);
        }
        return PHP_EOL . join(PHP_EOL, $output) . PHP_EOL;
    }
}
