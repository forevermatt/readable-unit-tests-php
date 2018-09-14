<?php

require('vendor/autoload.php');

$testPreparer = new \ReadableUnitTests\Preparer();
echo $testPreparer->generateMissingTestFilesFor($argv[1] ?? '');
