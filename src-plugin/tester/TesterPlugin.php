<?php
namespace tester;

use packager\Event;
use packager\JavaExec;
use packager\Vendor;
use php\format\JsonProcessor;
use php\lib\arr;
use php\lib\fs;
use phpx\parser\ClassRecord;
use phpx\parser\SourceFile;
use phpx\parser\SourceManager;

/**
 *
 * @jppm-task-prefix tester
 *
 * @jppm-task run
 */
class TesterPlugin
{
    /**
     * @jppm-need-package
     *
     * @jppm-dependency-of test
     *
     * @jppm-description Run all tests.
     * @param $event
     */
    public function run(Event $event)
    {
        \Tasks::run('install');

        $vendor = new Vendor($event->package()->getConfigVendorPath());

        $exec = new JavaExec();
        $exec->setSystemProperties([
            'bootstrap.file' => 'res://tester/.bootstrap.php'
        ]);

        $exec->addPackageClassPath($event->package());
        $exec->addVendorClassPath($vendor);
        $exec->addVendorClassPath($vendor, 'dev');
        $exec->addClassPath("./tests/");

        $files = fs::scan("./tests/", ['extensions' => ['php']]);

        $manager = new SourceManager();

        $testCases = [];

        foreach ($files as $file) {
            $source = new SourceFile($file, fs::relativize($file, "./tests/"));
            $source->update($manager);

            foreach ($source->moduleRecord->getClasses() as $class) {
                if ($this->isTestCase($class, $testCases)) {
                    $testCases[$class->name] = $class;
                }
            }
        }

        foreach ($files as $file) {
            $source = new SourceFile($file, fs::relativize($file, "./tests/"));
            $source->update($manager);

            foreach ($source->moduleRecord->getClasses() as $class) {
                if ($testCases[$class->name]) continue;

                if ($this->isTestCase($class, $testCases)) {
                    $testCases[$class->name] = $class;
                }
            }
        }

        fs::format("./tests/tester.json", [
            'testCases' => flow($testCases)
                ->find(function ($class) { return !$class->abstract; })
                ->map(function ($class) { return $class->name; })
                ->toArray()
        ], JsonProcessor::SERIALIZE_PRETTY_PRINT);

        $process = $exec->run();
        $process = $process->inheritIO()->startAndWait();

        exit($process->getExitValue());
    }

    protected function isTestCase(ClassRecord $record, array $otherTestCases = [])
    {
        if ($record->parent && $record->type === 'CLASS') {
            if ($record->parent->name === 'tester\TestCase' || $otherTestCases[$record->parent->name]) {
                return true;
            }
        }

        return false;
    }
}