<?php
namespace tester;

use Throwable;

/**
 * Class AssertionError
 * @package tester
 */
class AssertionError extends \Error
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getTestCaseTrace(): array
    {
        $result = null;
        $trace = $this->getTrace();

        foreach ($trace as $i => $item) {
            if (($item['object'] instanceof TestCase) && $trace[$i + 1]) {
                $result = $trace[$i + 1];
            }
        }

        return $result;
    }
}