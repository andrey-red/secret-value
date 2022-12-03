<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue;

interface MaskingRule
{
    public function mask(Secret $secret): string;
}
