<?php
namespace ReadableUnitTests;

class Runner
{
    public function runTests($path)
    {
        $output = '';
        $files = $this->getFilesInPath($path);
        foreach ($files as $file) {
            $output .= Test::run($file);
        }
        return $output;
    }

    protected function getFilesInPath($path)
    {
        $realPath = realpath($path) . DIRECTORY_SEPARATOR;
        $realPathLength = strlen($realPath);

        $files = [];
        $folderIterator = new \RecursiveDirectoryIterator($realPath);
        foreach (new \RecursiveIteratorIterator($folderIterator) as $filePath)
        {
            if ( ! $filePath->isDir()) {
                // Just get the relative path.
                $files[] = substr($filePath->getPathName(), $realPathLength);
            }
        }
        return $files;
    }
}
