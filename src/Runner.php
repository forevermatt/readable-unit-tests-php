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
        return join(PHP_EOL, $output);
    }
}
