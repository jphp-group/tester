<?php
namespace tester;

use php\lang\System;

/**
 * Class StdoutPrinter
 * @package tester
 */
class StdoutPrinter extends Printer
{
    /**
     * @param $text
     */
    public function write($text)
    {
        System::out()->write($text);
    }
}