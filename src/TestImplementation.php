<?php
namespace ReadableUnitTests;

use Behat\Gherkin\Node\FeatureNode;
use Webmozart\Assert\Assert;

class TestImplementation
{
    /** @var string */
    private $path;
    
    public function __construct(string $path)
    {
        $realPath = realpath($path);
        Assert::fileExists($realPath);
        $this->path = $realPath;
    }
}
