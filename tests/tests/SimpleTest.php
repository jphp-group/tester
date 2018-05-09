<?php

use tester\Assert;
use tester\TestCase;

class SimpleTest extends TestCase
{
    public function testEqual()
    {
        Assert::isEqual(1, 1);
    }

    public function testIdentical()
    {
        Assert::isIdentical(1, 1);
    }

    public function testEmpty()
    {
        Assert::isEmpty("");
    }
}