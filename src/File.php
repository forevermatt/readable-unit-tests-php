<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class File
{
    const TESTS_FOLDER_NAME = 'tests';
    const TEST_SPECIFICATION_SUFFIX = '.test';

    /** @var string */
    protected $folderPath;
    
    /** @var string */
    protected $relativeFilePath;
    
    /**
     * File constructor.
     *
     * @param string $folderPath The path to a folder containing this file. Must
     *     end with a directory separator (e.g. a slash).
     * @param string $relativeFilePath The path to this file relative to the
     *     given folder.
     */
    public function __construct(string $folderPath, string $relativeFilePath)
    {
        Assert::fileExists($folderPath . $relativeFilePath);
        Assert::endsWith($folderPath, DIRECTORY_SEPARATOR);
        $this->folderPath = $folderPath;
        $this->relativeFilePath = $relativeFilePath;
    }

    public function __toString(): string
    {
        return json_encode([
            'folderPath' => $this->folderPath,
            'relativeFilePath' => $this->relativeFilePath,
            'pathToTestSpecification' => $this->getPathToTestSpecification(),
        ]);
    }
    
    public function getPathToTestSpecification()
    {
        $relativePathInfo = pathinfo($this->relativeFilePath);
        return realpath(join('', [
            $this->folderPath,
            self::TESTS_FOLDER_NAME,
            DIRECTORY_SEPARATOR,
            $relativePathInfo['dirname'],
            DIRECTORY_SEPARATOR,
            $relativePathInfo['filename'],
            self::TEST_SPECIFICATION_SUFFIX
        ]));
    }
    
    public function getRelativePath(): string
    {
        return $this->relativeFilePath;
    }
    
    public function hasTestSpecification(): bool
    {
        $pathToTestSpec = $this->getPathToTestSpecification();
        return file_exists($pathToTestSpec);
    }
    
    public function isFileToTest(): bool
    {
        return strpos($this->relativeFilePath, self::TESTS_FOLDER_NAME . DIRECTORY_SEPARATOR) !== 0;
    }
}
