<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\Example;

use AndreyRed\SecretValue\AbstractSecret;
use AndreyRed\SecretValue\Exception\InvalidArgumentException;
use AndreyRed\SecretValue\MaskingRule;
use function preg_match;

class Passport extends AbstractSecret
{
    public static function name(): string
    {
        return 'Domestic Passport Number';
    }

    protected function getMaskingRule(): MaskingRule
    {
        return new MaskingRule\FixedLengthMask();
    }

    protected function assertValueValid(string $value): void
    {
        if (!preg_match('/^\d{10}$/', $value)) {
            throw new InvalidArgumentException(self::name() . ' should be a string containing 10 digits');
        }
    }
}
