<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue;

use RuntimeException;
use function fclose;
use function fopen;
use function is_resource;
use function rewind;
use function stream_get_contents;
use function urlencode;

abstract class AbstractSecret implements Secret
{
    private const RESOURCE_OPEN_MODE = 'rb';

    /** @var resource|null It may become null after unserializing */
    private $value;

    abstract protected function getMaskingRule(): MaskingRule;

    final public function __construct(string $value)
    {
        $resource = fopen(
            'data:text/plain,' . urlencode($value),
            self::RESOURCE_OPEN_MODE
        );

        if ($resource === false) {
            throw new RuntimeException('Failed to create the secret');
        }

        $this->value = $resource;
    }

    final public function equalTo(Secret $other): bool
    {
        return static::class === $other::class
            && $this->reveal() === $other->reveal();
    }

    public function revealable(): bool
    {
        return is_resource($this->value);
    }

    final public function reveal(): string
    {
        if (false !== ($revealed = stream_get_contents($this->value))) {
            rewind($this->value);

            return (string) $revealed;
        }

        throw new RuntimeException('Failed to restore the secret');
    }

    final public function __toString(): string
    {
        return $this->getMaskingRule()->mask($this);
    }

    private function __clone()
    {
        // what do you want to clone the secret for?
    }

    final public function __serialize(): array
    {
        return [
            'value' => null,
        ];
    }

    final public function __unserialize(array $data): void
    {
        $this->value = null;
    }

    final public function __debugInfo(): array
    {
        return [
            'value' => (string) $this,
        ];
    }

    final public function __destruct()
    {
        if (is_resource($this->value)) {
            fclose($this->value);
        }
    }
}
