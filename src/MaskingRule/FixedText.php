<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\MaskingRule;

use AndreyRed\SecretValue\MaskingRule;
use AndreyRed\SecretValue\Secret;

class FixedText implements MaskingRule
{

    public function __construct(
        private readonly string $text,
    ) {}

    public function mask(Secret $secret): string
    {
        return $this->text;
    }
}
