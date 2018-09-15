<?php

require('vendor/autoload.php');

$logger = new \ReadableUnitTests\BasicLogger();
$testRunner = new \ReadableUnitTests\Runner($logger);
$exitCode = $testRunner->runTests($argv[1] ?? '');
exit($exitCode);
