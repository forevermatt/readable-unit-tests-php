<?php

require('vendor/autoload.php');

$testRunner = new \ReadableUnitTests\Runner();
echo $testRunner->runTests('./sample');
