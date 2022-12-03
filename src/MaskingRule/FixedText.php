<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\MaskingRule;

use AndreyRed\SecretValue\MaskingRule;
use AndreyRed\SecretValue\SecretValue;

class FixedText implements MaskingRule
{

    public function __construct(
        private readonly string $text,
    ) {}

    public function mask(SecretValue $secret): string
    {
        return $this->text;
    }
}
