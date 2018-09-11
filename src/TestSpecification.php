<?php
namespace ReadableUnitTests;

use Behat\Gherkin\Node\FeatureNode;
use Webmozart\Assert\Assert;

class TestSpecification
{
    /** @var File */
    private $fileToTest;
    
    /**
     * @var FeatureNode
     */
    private $class;
    
    public function __construct(File $fileToTest)
    {
        $this->fileToTest = $fileToTest;
        
        $path = $fileToTest->getPathToTestSpecification();
        Assert::fileExists($path);
        
        $class = self::parseSpecification($path);
        Assert::notNull($class, 'No class found in test specification.');
        $this->class = $class;
    }
    
    protected static function parseSpecification($path)
    {
        Assert::fileExists($path);
        
        $keywords = new \Behat\Gherkin\Keywords\ArrayKeywords([
            'en' => [
                'feature'          => 'Class',
                'background'       => 'Background',
                'scenario'         => 'Scenario',
                'scenario_outline' => 'Scenario Outline|Scenario Template',
                'examples'         => 'Examples|Scenarios',
                'given'            => 'Given',
                'when'             => 'When',
                'then'             => 'Then',
                'and'              => 'And',
                'but'              => 'But'
            ],
        ]);
        $lexer  = new \Behat\Gherkin\Lexer($keywords);
        $parser = new \Behat\Gherkin\Parser($lexer);
        
        return $parser->parse(file_get_contents($path));
    }
    
    /**
     * @return \Behat\Gherkin\Node\ScenarioInterface[]
     */
    public function getScenarios()
    {
        Assert::isInstanceOf($this->class, FeatureNode::class);
        return $this->class->getScenarios();
    }
    
    public static function createFor(File $fileToTest)
    {
        $pathToTestSpecification = $fileToTest->getPathToTestSpecification();
        
        if (file_exists($pathToTestSpecification)) {
            return sprintf('  "' . $pathToTestSpecification . '" already exists.');
        }
        
        $fileContents = self::createSpecificationContentsFor($fileToTest);
        File::createAt($pathToTestSpecification, $fileContents);
        return '+ "' . $pathToTestSpecification . '" created.';
    }
    
    public static function createSpecificationContentsFor(File $fileToTest)
    {
        return str_replace(
            'ClassPath',
            $fileToTest->getPhpFullClassPath(),
            file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'specification-template.txt')
        );
    }
}
