<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue;

use function error_get_last;
use function fclose;
use function fopen;
use function is_resource;
use function rewind;
use function stream_get_contents;
use function trigger_error;
use function urlencode;

use const E_USER_WARNING;

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
            $errorReason = (null !== ($error = error_get_last()))
                ? $error['message']
                : null;

            throw new Exception\RuntimeException(sprintf(
                'Failed to create the secret: %s',
                $errorReason ?: 'unknown reason'
            ));
        }

        $this->value = $resource;
    }

    final public function reveal(): string
    {
        if (!is_resource($this->value)) {
            throw new Exception\RuntimeException('The secret has no value. Was the secret deserialized?');
        }

        rewind($this->value);

        if (false === ($revealed = stream_get_contents($this->value))) {
            throw new Exception\RuntimeException('Failed to restore the secret');
        }

        return (string) $revealed;
    }

    public function revealable(): bool
    {
        return is_resource($this->value);
    }

    final public function equalsTo(Secret $other): bool
    {
        return static::class === $other::class
            && $this->reveal() === $other->reveal();
    }

    final public function __toString(): string
    {
        return $this->getMaskingRule()->mask($this);
    }

    final public function jsonSerialize(): string
    {
        return (string) $this;
    }

    private function __clone()
    {
        // what do you want to clone the secret for?
    }

    /** @return array<string, mixed> */
    final public function __serialize(): array
    {
        $this->emitSerializationError('serialize');

        return [
            'value' => null,
        ];
    }

    /** @param array<string, mixed> $data */
    final public function __unserialize(array $data): void
    {
        $this->emitSerializationError('unserialize');

        $this->value = null;
    }

    /** @return array{value: string} */
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

    protected function getSerializationErrorLevel(): int
    {
        return E_USER_WARNING;
    }

    protected function emitSerializationError(string $action): void
    {
        trigger_error(
            "Trying to {$action} a secret value of " . static::name(),
            $this->getSerializationErrorLevel(),
        );
    }
}
