<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class File
{
    const TESTS_FOLDER_NAME = 'tests';
    const TEST_IMPLEMENTATION_SUFFIX = 'Test.php';
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
    
    public static function createAt(string $pathToFile, string $fileContents)
    {
        $pathToFolder = dirname($pathToFile);
        
        if (! file_exists($pathToFolder)) {
            Assert::true(
                mkdir($pathToFolder, 0x755, true),
                'Failed to create folder at "' . $pathToFolder . '".'
            );
        }
        
        $result = file_put_contents($pathToFile, $fileContents);
        Assert::notSame(false, $result, 'Failed to create "' . $pathToFile . '" file.');
    }
    
    public function __toString(): string
    {
        return json_encode([
            'folderPath' => $this->folderPath,
            'relativeFilePath' => $this->relativeFilePath,
            'pathToTestSpecification' => $this->getPathToTestSpecification(),
        ]);
    }
    
    public function getPath()
    {
        return $this->folderPath . $this->relativeFilePath;
    }
    
    public function getPathToTestImplementation()
    {
        $relativePathInfo = pathinfo($this->relativeFilePath);
        return join('', [
            $this->getPathToTestFilesFolder(),
            $relativePathInfo['filename'],
            self::TEST_IMPLEMENTATION_SUFFIX
        ]);
    }
    
    public function getPathToTestSpecification()
    {
        $relativePathInfo = pathinfo($this->relativeFilePath);
        return join('', [
            $this->getPathToTestFilesFolder(),
            $relativePathInfo['filename'],
            self::TEST_SPECIFICATION_SUFFIX
        ]);
    }
    
    protected function getPathToTestFilesFolder()
    {
        $relativePathInfo = pathinfo($this->relativeFilePath);
        $pathPieces = [
            dirname($this->folderPath),
            self::TESTS_FOLDER_NAME,
            'unit',
        ];
        if ($relativePathInfo['dirname'] !== '.') {
            $pathPieces[] = $relativePathInfo['dirname'];
        }
        return join(DIRECTORY_SEPARATOR, $pathPieces) . DIRECTORY_SEPARATOR;
    }
    
    public function getRelativePath(): string
    {
        return $this->relativeFilePath;
    }
    
    public function isFileToTest(): bool
    {
        $isPhpFile = (substr($this->relativeFilePath, -4) === '.php');
        $isNotInTestsFolder = (strpos($this->relativeFilePath, self::TESTS_FOLDER_NAME . DIRECTORY_SEPARATOR) !== 0);
        
        return $isPhpFile && $isNotInTestsFolder;
    }
    
    public function getPhpFullClassPath()
    {
        $namespace = $this->getPhpNamespace();
        $className = $this->getPhpClassName();
        
        if (empty($namespace)) {
            return '\\' . $className;
        }
        return '\\' . $namespace . '\\' . $className;
    }
    
    public function getPhpNamespace()
    {
        $phpFileContents = file_get_contents($this->getPath());
        $namespaceMatches = [];
        $pregMatchResult = preg_match(
            '/namespace *([^;]+);/',
            $phpFileContents,
            $namespaceMatches
        );
        
        if (empty($pregMatchResult)) {
            return null;
        }
        return trim($namespaceMatches[1]);
    }
    
    public function getPhpClassName()
    {
        $phpFileContents = file_get_contents($this->getPath());
        $classNameMatches = [];
        $pregMatchResult = preg_match(
            '/class *([A-Za-z0-9]+)[^{]*{/',
            $phpFileContents,
            $classNameMatches
        );
        Assert::notEmpty($pregMatchResult, 'Failed to find PHP class name in ' . $this->getPath());
        return $classNameMatches[1];
    }
}
