<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\Exception;

use RuntimeException as CoreRuntimeException;

class RuntimeException extends CoreRuntimeException implements SecretValueException
{
}
