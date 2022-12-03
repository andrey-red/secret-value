<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\example;

use AndreyRed\SecretValue\AbstractSecret;
use AndreyRed\SecretValue\MaskingRule;

class Passport extends AbstractSecret
{
    protected function getMaskingRule(): MaskingRule
    {
        return new MaskingRule\FixedLengthMask();
    }
}
