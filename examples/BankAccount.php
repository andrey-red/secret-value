<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\Example;

use AndreyRed\SecretValue\AbstractSecret;
use AndreyRed\SecretValue\Exception\InvalidArgumentException;
use AndreyRed\SecretValue\MaskingRule;

use function preg_match;

class BankAccount extends AbstractSecret
{
    public static function name(): string
    {
        return 'Bank Account Number';
    }

    protected function getMaskingRule(): MaskingRule
    {
        return new MaskingRule\FixedLengthMask(8);
    }

    protected function assertValueValid(string $value): void
    {
        if (!preg_match('/^\d{12,16}$/', $value)) {
            throw new InvalidArgumentException(self::name() . ' should be a string containing 12 to 16 digits');
        }
    }
}
