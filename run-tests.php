<?php

require('vendor/autoload.php');

$logger = new \Sil\Psr3Adapters\Psr3ConsoleLogger();
$testRunner = new \ReadableUnitTests\Runner($logger);
$exitCode = $testRunner->runTests($argv[1] ?? '');
exit($exitCode);
