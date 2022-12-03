<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue;

interface Secret
{
    public function __construct(string $value);

    public function revealable(): bool;

    public function reveal(): string;

    public function __toString(): string;

    /** array{value: null} */
    public function __serialize(): array;

    public function __unserialize(array $data): void;

    public function __debugInfo(): array;

    public function __destruct();
}
