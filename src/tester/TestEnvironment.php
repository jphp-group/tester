<?php

namespace tester;

use php\lang\System;
use php\lib\fs;
use php\lib\reflect;
use php\lib\str;

/**
 * Class TestEnvironment
 * @package tester
 */
class TestEnvironment
{
    /**
     * @var Printer[]
     */
    private $printers = [];

    /**
     * @param Printer $printer
     */
    public function addPrinter(Printer $printer)
    {
        $this->printers[] = $printer;
    }

    /**
     * @param array $config
     */
    public function run(array $config)
    {
        $result = [];

        $testCases = (array) $config['testCases'];

        if (!$testCases) {
            $this->log("No test cases.");
            return;
        }

        foreach ($testCases as $testCase) {
            try {
                $testCase = new $testCase();

                if (!($testCase instanceof TestCase)) {
                    $this->fail("Test '{0}' doesn't extend 'TestCase' class", reflect::typeOf($testCase));
                }

                $cls = new \ReflectionClass($testCase);

                $setUp = function () {
                };
                $tearDown = function () {
                };

                try {
                    $method = $cls->getMethod('setUp');
                    if ($method && !$method->isAbstract()) {
                        $method->setAccessible(true);
                        $setUp = function () use ($testCase, $method) {
                            $method->invoke($testCase);
                        };
                    }
                } catch (\ReflectionException $e) { }

                try {
                    $method = $cls->getMethod('tearDown');
                    if ($method && !$method->isAbstract()) {
                        $method->setAccessible(true);
                        $tearDown = function () use ($testCase, $method) {
                            $method->invoke($testCase);
                        };
                    }
                } catch (\ReflectionException $e) { }

                foreach ($cls->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                    if ($method->isAbstract()) continue;

                    if (str::startsWith($method->getName(), "test")) {
                        $setUp();

                        try {
                            $method->invoke($testCase);
                            $this->log("-> {0}.{1}() is OK.", reflect::typeOf($testCase), $method->getName());

                        } catch (AssertionError $e) {
                            $result[reflect::typeOf($testCase)][$method->getName()] = $e;
                            $this->log("-> {0}.{1}() is FAIL.", reflect::typeOf($testCase), $method->getName());
                        } finally {
                            $tearDown();
                        }
                    }
                }

                $this->print("-> {0}", reflect::typeOf($testCase));

                if ($errors = $result[reflect::typeOf($testCase)]) {
                    $this->log(" is FAIL, {0} errors.", sizeof($errors));
                } else {
                    $this->log(" is OK.");
                }

            } catch (\Throwable $e) {
                $this->print("");
                $this->log("\nTesting is DOWN.");
                $this->fail($e->getMessage());
            } finally {

            }
        }

        if ($result) {
            $this->log("\nTesting is FAILED, error(s):");

            foreach ($result as $test => $errors) {
                $this->log(" -> {0}", $test);

                $lineSize = 30;

                /**
                 * @var AssertionError $error
                 */
                foreach ($errors as $method => $error) {
                    $this->log("  |");
                    $msg = $this->log("  |  {0}() - {1}", $method, $error->getMessage());

                    if ($lineSize < str::length($msg)) {
                        $lineSize = str::length($msg);
                    }

                    if ($trace = $error->getTestCaseTrace()) {
                        $msg = $this->log("  |    -> in '{0}' at line {1}", $trace['file'], $trace['line']);
                        if ($lineSize < str::length($msg)) {
                            $lineSize = str::length($msg);
                        }
                    }
                }

                $this->log("  |{0} // {1}.", str::repeat("_", $lineSize), $test);
            }

            $this->fail("\n[FAILED] Some test(s) are is failed!");
            return false;
        } else {
            $this->log("\n[SUCCESSFUL] All {0} test(s) are successful.", sizeof((array) $config['testCases']));
            return true;
        }
    }

    public function fail($message, ...$args)
    {
        $this->print($message, ...$args);
        exit(1);
    }

    public function log($message, ...$args)
    {
        return $this->print("$message\n", ...$args);
    }

    public function print($message, ...$args)
    {
        foreach ($args as $i => $arg) $message = str::replace($message, "{{$i}}", $arg);

        foreach ($this->printers as $printer) {
            $printer->write($message);
        }

        return $message;
    }
}