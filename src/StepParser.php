<?php
namespace ReadableUnitTests;

use Webmozart\Assert\Assert;

class StepParser
{
    /** @var string */
    protected $functionName;
    
    /** @var array */
    protected $arguments;
    
    public function __construct(string $stepKeyword, string $stepText)
    {
        $functionName = strtolower($stepKeyword);
        $arguments = [];
        
        foreach (self::tokenize($stepText) as $word) {
            if (is_numeric($word)) {
                $functionName .= 'Number';
                $arguments[] = $word + 0;
                continue;
            }
            
            if (self::isStringDelimiter($word[0])) {
                $functionName .= 'String';
                $arguments[] = trim($word, $word[0]); // Trim off the string delimiters.
                continue;
            }
            
            $functionName .= self::formatForFunctionName($word);
        }
        
        $this->functionName = $functionName;
        $this->arguments = $arguments;
    }
    
    public static function tokenize(string $stepText)
    {
        $stepTextTokens = [];
        
        $tempToken = '';
        for ($i = 0; $i < strlen($stepText); $i++) {
            $character = $stepText[$i];
            
            if (self::isWhiteSpace($character)) {
                if ($tempToken !== '') {
                    $stepTextTokens[] = $tempToken;
                    $tempToken = '';
                }
                continue;
            }
            
            if (self::isStringDelimiter($character)) {
                $nextStringDelimiterIndex = strpos($stepText, $character, $i + 1);
                $stringLength = ($nextStringDelimiterIndex - $i) + 1;
                $stepTextTokens[] = substr($stepText, $i, $stringLength);
                
                $i += $stringLength;
                continue;
            }
            
            $tempToken .= $character;
        }
        if (! empty($tempToken)) {
            $stepTextTokens[] = $tempToken;
        }
        
        return $stepTextTokens;
    }
    
    public static function isStringDelimiter(string $character)
    {
        Assert::length($character, 1);
        return in_array($character, ['"', "'"], true);
    }
    
    public static function formatForFunctionName(string $word)
    {
        $lowerCaseWord = strtolower($word);
        $alphaNumericWord = preg_replace('/[^A-Za-z0-9]/', '', $lowerCaseWord);
        return ucfirst($alphaNumericWord);
    }
    
    public static function isWhiteSpace(string $character)
    {
        Assert::length($character, 1);
        return in_array($character, [' ', "\t"], true);
    }
    
    public function getFunctionName()
    {
        return $this->functionName;
    }
    
    public function getArguments()
    {
        return $this->arguments;
    }
}
