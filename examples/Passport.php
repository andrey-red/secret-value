<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\Example;

use AndreyRed\SecretValue\AbstractSecret;
use AndreyRed\SecretValue\MaskingRule;

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
}
