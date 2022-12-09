<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\Test;

use AndreyRed\SecretValue\AbstractSecret;
use AndreyRed\SecretValue\Exception\InvalidArgumentException;
use AndreyRed\SecretValue\MaskingRule;

use function preg_match;

class ThreeDigitsTestSecret extends AbstractSecret
{
    public const MASKED_TEXT = '[secret]';
    public const WRONG_VALUE_MESSAGE = 'three digits expected';

    public static function name(): string
    {
        return 'Test Secret';
    }

    protected function getMaskingRule(): MaskingRule
    {
        return new MaskingRule\FixedText(self::MASKED_TEXT);
    }

    protected function assertValueValid(string $value): void
    {
        if (!preg_match('/^\d+$/', $value)) {
            throw new InvalidArgumentException(self::WRONG_VALUE_MESSAGE);
        }
    }
}
