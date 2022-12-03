<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\Example;

use AndreyRed\SecretValue\AbstractSecretValue;
use AndreyRed\SecretValue\MaskingRule;

class BankAccount extends AbstractSecretValue
{
    public static function name(): string
    {
        return 'Bank Account Number';
    }

    protected function getMaskingRule(): MaskingRule
    {
        return new MaskingRule\FixedLengthMask(8);
    }
}
