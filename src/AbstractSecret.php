<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue;

abstract class AbstractSecret extends ExtendableAbstractSecret
{
    final public function __construct(string $value)
    {
        parent::__construct($value);
    }

    final public function reveal(): string
    {
        return parent::reveal();
    }

    final public function revealable(): bool
    {
        return parent::revealable();
    }

    final public function equalsTo(Secret $other): bool
    {
        return parent::equalsTo($other);
    }

    final public function __toString(): string
    {
        return parent::__toString();
    }

    final public function jsonSerialize(): string
    {
        return parent::jsonSerialize();
    }

    private function __clone()
    {
        // what do you want to clone the secret for?
    }

    final public function __serialize(): array
    {
        return parent::__serialize();
    }

    final public function __unserialize(array $data): void
    {
        parent::__unserialize($data);
    }

    final public function __debugInfo(): array
    {
        return parent::__debugInfo();
    }

    final public function __destruct()
    {
        parent::__destruct();
    }
}
