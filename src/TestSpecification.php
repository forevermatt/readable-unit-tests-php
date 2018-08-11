<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class TestSpecification
{
    /** @var string */
    private $path;
    private $features;
    
    public function __construct(string $path)
    {
        $realPath = realpath($path);
        Assert::fileExists($realPath);
        $this->path = $realPath;
        $this->features = self::parseSpecification($this->path);
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
}
