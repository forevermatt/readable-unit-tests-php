<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class File
{
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
        return strpos($this->relativeFilePath, 'test' . DIRECTORY_SEPARATOR) !== 0;
    }
}
