<?php
namespace tester;

/**
 *
 */
abstract class TestCase
{
    /**
     * @param $expected
     * @param $actual
     * @param string $message
     */
    public function assertEquals($expected, $actual, string $message = '')
    {
        $this->assertThat($expected, Constraint::isEqual($actual), $message);
    }

    /**
     * @param $expected
     * @param $actual
     * @param string $message
     */
    public function assertNotEquals($expected, $actual, string $message = '')
    {
        $this->assertThat($expected, Constraint::isNot(Constraint::isEqual($actual)), $message);
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @param string $message
     */
    public function assertThat($value, Constraint $constraint, string $message = "")
    {
        if (!$constraint->evalute($value)) {
            $value = var_export($value, true);

            echo "{$value} {$constraint->getMessage()}", "\n";
        }
    }
}