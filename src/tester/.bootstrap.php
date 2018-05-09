<?php

use php\lib\fs;
use tester\StdoutPrinter;
use tester\TestEnvironment;

$env = new TestEnvironment();
$env->addPrinter(new StdoutPrinter());
$env->run(fs::parse("./tests/tester.json"));