<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue;

use JsonSerializable;

interface Secret extends JsonSerializable
{
    /** @param non-empty-string $value */
    public function __construct(string $value);

    public static function name(): string;

    public function revealable(): bool;

    /** @return string */
    public function reveal(): string;

    public function equalsTo(Secret $other): bool;

    public function __toString(): string;

    /** @return array{value: null} */
    public function __serialize(): array;

    /** @param array<string, mixed> $data */
    public function __unserialize(array $data): void;

    /** @return array{value: string} */
    public function __debugInfo(): array;
}
