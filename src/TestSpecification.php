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
    private $feature;
    
    public function __construct(File $fileToTest)
    {
        $this->fileToTest = $fileToTest;
        
        $path = $fileToTest->getPathToTestSpecification();
        Assert::fileExists($path);
        
        $feature = self::parseSpecification($path);
        Assert::notNull($feature, 'No feature found in test specification.');
        $this->feature = $feature;
    }
    
    protected static function parseSpecification($path)
    {
        Assert::fileExists($path);
        
        $keywords = new \Behat\Gherkin\Keywords\ArrayKeywords([
            'en' => [
                'feature'          => 'Feature',
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
    
    public function getFeature()
    {
        return $this->feature;
    }
    
    /**
     * @return \Behat\Gherkin\Node\ScenarioInterface[]
     */
    public function getScenarios()
    {
        Assert::isInstanceOf($this->feature, FeatureNode::class);
        return $this->feature->getScenarios();
    }
    
}
