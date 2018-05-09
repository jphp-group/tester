<?php
namespace tester;

use php\io\Stream;

/**
 * Class Printer
 * @package tester
 */
abstract class Printer
{
    /**
     * @param $text
     */
    abstract public function write($text);
}