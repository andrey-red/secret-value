<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\MaskingRule;

use AndreyRed\SecretValue\MaskingRule;
use AndreyRed\SecretValue\Secret;
use function str_repeat;

class FixedLengthMask implements MaskingRule
{
    public function __construct(
        private readonly int $length = 5,
        private readonly string $symbol = '*',
    ) {}

    public function mask(Secret $secret): string
    {
        return str_repeat($this->symbol, $this->length);
    }
}
