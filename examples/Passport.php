<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\Example;

use AndreyRed\SecretValue\AbstractSecretValue;
use AndreyRed\SecretValue\MaskingRule;

class Passport extends AbstractSecretValue
{
    public static function name(): string
    {
        return 'Domestic Passport Number';
    }

    protected function getMaskingRule(): MaskingRule
    {
        return new MaskingRule\FixedLengthMask();
    }
}
