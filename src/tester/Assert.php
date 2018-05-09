<?php
namespace tester;


use php\lib\reflect;
use php\lib\str;

class Assert
{
    /**
     * @param $value
     * @return string
     */
    static protected function formatValue($value): string
    {
        if ($value === null) {
            return "NULL";
        }

        if (is_object($value)) {
            return "instance of " . reflect::typeOf($value);
        }

        if (is_array($value)) {
            $result = var_export($value, true);
            if (str::length($result) > 255) {
                return "Array<" . sizeof($value) . ">";
            } else {
                return $result;
            }
        }

        return var_export($value, true);
    }

    /**
     * @param string $message
     * @param array ...$args
     * @throws AssertionError
     */
    static function fail(string $message, $formatted, ...$args)
    {
        foreach ($args as $i => $arg) {
            $formatted = str::replace($formatted, "\{$i\}", Assert::formatValue($arg));
        }

        if (isset($message) && $message !== '') {
            $formatted = "$message, $formatted";
        }

        throw new AssertionError($formatted);
    }

    /**
     * @param $expected
     * @param $actual
     * @param string|null $message
     * @throws AssertionError
     */
    static function isEqual($expected, $actual, string $message = null)
    {
        if ($expected != $actual) {
            Assert::fail($message, "expected: {0}, but was: {1}", $expected, $actual);
        }
    }

    /**
     * @param $expected
     * @param $actual
     * @param string|null $message
     */
    static function isIdentical($expected, $actual, string $message = null)
    {
        if ($expected !== $actual) {
            Assert::fail($message, 'expected: {0}, but was: {1}, is not identical', $expected, $actual);
        }
    }

    /**
     * @param $actual
     * @param string|null $message
     */
    static function isNull($actual, string $message = null)
    {
        if ($actual !== null) {
            Assert::fail($message, "expected NULL, but was: {0}", $actual);
        }
    }

    /**
     * @param $actual
     * @param string|null $message
     */
    static function isNotNull($actual, string $message = null)
    {
        if ($actual === null) {
            Assert::fail($message, "expected not NULL, but was: {0}", $actual);
        }
    }

    /**
     * @param $actual
     * @param string|null $message
     */
    static function isTrue($actual, string $message = null)
    {
        if ($actual !== true) {
            Assert::fail($message, "expected true, but was: {0}", $actual);
        }
    }

    /**
     * @param $actual
     * @param string|null $message
     */
    static function isFalse($actual, string $message = null)
    {
        if ($actual !== false) {
            Assert::fail($message, "expected false, but was: {0}", $actual);
        }
    }

    /**
     * @param $actual
     * @param string|null $message
     */
    static function isEmpty($actual, string $message = null)
    {
        if (!empty($actual)) {
            Assert::fail($message, "expected empty, but was: {0}", $actual);
        }
    }

    /**
     * @param $actual
     * @param string|null $message
     */
    static function isNotEmpty($actual, string $message = null)
    {
        if (empty($actual)) {
            Assert::fail($message, "expected not empty, but was: {0}", $actual);
        }
    }
}