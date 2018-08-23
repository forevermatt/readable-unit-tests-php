<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;
use ReadableUnitTests\File;

class Folder
{
    /** @var string */
    protected $realPath;

    public function __construct(string $path)
    {
        $realPathResult = realpath($path);
        Assert::notEmpty(
            $realPathResult,
            'No such folder: ' . var_export($path, true)
        );
        $this->realPath = $realPathResult;
    }

    /**
     * @return File[] The Files in this Folder.
     */
    public function getFilesToTest()
    {
        $folderPath = $this->realPath . DIRECTORY_SEPARATOR;
        $folderPathLength = strlen($folderPath);

        $files = [];
        $folderIterator = new \RecursiveDirectoryIterator($folderPath);
        foreach (new \RecursiveIteratorIterator($folderIterator) as $filePath) {
            if ($filePath->isDir()) {
                continue;
            }

            $file = new File(
                $folderPath,
                substr($filePath->getPathName(), $folderPathLength)
            );

            if ($file->isFileToTest()) {
                $files[] = $file;
            }
        }
        return $files;
    }
}
