<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use ReadableUnitTests\Runner;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var string[] */
    protected $files;

    /** @var Runner */
    protected $runner;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->files = [];
        $this->runner = new Runner();
    }

    /**
     * @Given a file at :path
     */
    public function aFileAt($path)
    {
        $this->files[] = $path;
    }

    /**
     * @When I run the tests in :folderPath
     */
    public function iRunTheTestsIn($folderPath)
    {
        $this->runner = new Runner();
        $this->runner->runTests($folderPath);
    }

    /**
     * @Then the tests in :folderPath should have been be run
     */
    public function theTestsInShouldHaveBeenRun($folderPath)
    {
        throw new PendingException();
    }
}
