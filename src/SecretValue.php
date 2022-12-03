<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue;

use JsonSerializable;

interface SecretValue extends JsonSerializable
{
    /** @param non-empty-string $value */
    public function __construct(string $value);

    public static function name(): string;

    /** @return non-empty-string */
    public function reveal(): string;

    public function revealable(): bool;

    public function equalsTo(SecretValue $other): bool;

    public function __toString(): string;

    /** array{value: null} */
    public function __serialize(): array;

    public function __unserialize(array $data): void;

    public function __debugInfo(): array;
}
