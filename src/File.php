<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class File
{
    const TESTS_FOLDER_NAME = 'tests';

    protected $folderPath;
    protected $relativeFilePath;

    public function __construct($folderPath, $relativeFilePath)
    {
        Assert::fileExists($folderPath . $relativeFilePath);
        $this->folderPath = $folderPath;
        $this->relativeFilePath = $relativeFilePath;
    }

    public function __toString()
    {
        return json_encode([
            'folderPath' => $this->folderPath,
            'relativeFilePath' => $this->relativeFilePath,
        ]);
    }

    public function isFileToTest()
    {
        return strpos($this->relativeFilePath, self::TESTS_FOLDER_NAME . DIRECTORY_SEPARATOR) !== 0;
    }
}
