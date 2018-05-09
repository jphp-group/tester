<?php

namespace tester;
use php\lib\str;

/**
 * Class Constraint
 * @package tester
 */
class Constraint
{
    /**
     * @var array
     */
    private $args;
    private $value;

    /**
     * @var callable
     */
    private $evalute;
    /**
     * @var callable
     */
    private $getMessage;

    /**
     * Constraint constructor.
     * @param $value
     * @param array $args
     * @param callable $evalute
     * @param callable $getMessage
     */
    public function __construct($value, array $args, callable $evalute, callable $getMessage)
    {
        $this->args = $args;
        $this->value = $value;
        $this->evalute = $evalute;
        $this->getMessage = $getMessage;
    }

    public function getMessage(): string
    {
        return call_user_func($this->getMessage, $this->value, $this->args);
    }

    /**
     * @param $other
     * @return bool
     */
    public function evalute($other): bool
    {
        return call_user_func($this->evalute, $other, $this->value, $this->args);
    }

    /**
     * @param Constraint $constraint
     * @return Constraint
     */
    static function isNot(Constraint $constraint): Constraint
    {
        return new Constraint($constraint->value, [], function ($other, $expected) use ($constraint) {
            return !$constraint->evalute($other);
        }, function ($value, $args) use ($constraint) {
            return "is NOT ({$constraint->getMessage()})";
        });
    }

    /**
     * @param $value
     * @return Constraint
     */
    static function isEqual($value): Constraint
    {
        return new Constraint(
            $value, [],
            function ($other, $expected) {
                return $other == $expected;
            },
            function ($value, $args) {
                if (is_string($value)) {
                    $lines = str::lines($value);

                    if (sizeof($lines) < 2) {
                        return "is equal to \"$value\"";
                    } else {
                        return "is equal to <text> \"$lines[0] ...\"";
                    }
                } else {
                    return "is equal to " . var_export($value);
                }
            }
        );
    }
}