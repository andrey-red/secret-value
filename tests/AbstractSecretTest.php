<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\Test;

use AndreyRed\SecretValue\Exception\InvalidArgumentException;
use AndreyRed\SecretValue\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

use function json_decode;
use function json_encode;
use function ob_get_clean;
use function ob_start;
use function print_r;
use function serialize;
use function unserialize;
use function var_dump;
use function var_export;

class AbstractSecretTest extends TestCase
{
    private const SECRET_VALUE = '123';
    private const ANOTHER_VALID_VALUE = '321';

    public function testExceptionOnNotValidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(ThreeDigitsTestSecret::WRONG_VALUE_MESSAGE);

        new ThreeDigitsTestSecret('four');
    }

    public function testReveal(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);

        $this->assertTrue($secret->revealable());
        $this->assertSame(self::SECRET_VALUE, $secret->reveal());
    }

    public function testResourceRewindsOnReveal(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);

        $this->assertSame(self::SECRET_VALUE, $secret->reveal());
        $this->assertSame(self::SECRET_VALUE, $secret->reveal());
    }

    public function testDifferentSecretClassesAreNotEqual(): void
    {
        $secret1 = new ThreeDigitsTestSecret(self::SECRET_VALUE);
        $secret2 = new AnotherThreeDigitsTestSecret(self::SECRET_VALUE);

        $this->assertFalse($secret1->equalsTo($secret2));
        $this->assertFalse($secret2->equalsTo($secret1));
    }

    public function testSecretsWithDifferentValuesAreNotEqual(): void
    {
        $secret1 = new ThreeDigitsTestSecret(self::SECRET_VALUE);
        $secret2 = new ThreeDigitsTestSecret(self::ANOTHER_VALID_VALUE);

        $this->assertFalse($secret1->equalsTo($secret2));
        $this->assertFalse($secret2->equalsTo($secret1));
    }

    public function testMaskingOnToString(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);

        $this->assertSame(ThreeDigitsTestSecret::MASKED_TEXT, (string) $secret);
    }

    public function testMaskingOnJsonSerialize(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);

        /** @noinspection PhpUnhandledExceptionInspection */
        $json = json_encode(['secret' => $secret], JSON_THROW_ON_ERROR);

        $this->assertNotFalse($json);

        /** @noinspection JsonEncodingApiUsageInspection */
        $restoredJson = json_decode($json, true);
        $restoredSecretValue = $restoredJson['secret'];

        $this->assertSame(ThreeDigitsTestSecret::MASKED_TEXT, $restoredSecretValue);
    }

    public function testWarningOnSerialization(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);

        $this->assertTrue($secret->revealable());

        $this->expectWarning();
        $this->expectWarningMessage('serialize');

        serialize($secret);
    }

    public function testSerializedStringDoesNotContainSecret(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);
        $serialized = @serialize($secret);

        $this->assertStringNotContainsString(self::SECRET_VALUE, $serialized);
    }


    public function testWarningOnDeserialization(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);
        $serialized = @serialize($secret);

        $this->expectWarning();
        $this->expectWarningMessage('unserialize');

        unserialize($serialized);
    }

    public function testSecretNotRevealableAfterDeserialization(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);

        $this->assertTrue($secret->revealable());

        $serialized = @serialize($secret);
        /** @var ThreeDigitsTestSecret $unserialized */
        $unserialized = @unserialize($serialized);

        $this->assertFalse($unserialized->revealable());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Was the secret deserialized?');

        $unserialized->reveal();
    }

    public function testVarExportDumpsSecretAsNull(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);
        ob_start();
        var_export($secret);

        /** @var string $output */
        $output = ob_get_clean();

        $this->assertStringContainsString('NULL', $output);
        $this->assertStringNotContainsString(self::SECRET_VALUE, $output);
    }

    public function testVarDumpDoesNotContainSecret(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);
        ob_start();
        var_dump($secret);

        /** @var string $output */
        $output = ob_get_clean();

        $this->assertStringContainsString(ThreeDigitsTestSecret::MASKED_TEXT, $output);
        $this->assertStringNotContainsString(self::SECRET_VALUE, $output);
    }

    public function testPrintRDoesNotContainSecret(): void
    {
        $secret = new ThreeDigitsTestSecret(self::SECRET_VALUE);
        ob_start();
        print_r($secret);

        /** @var string $output */
        $output = ob_get_clean();

        $this->assertStringContainsString(ThreeDigitsTestSecret::MASKED_TEXT, $output);
        $this->assertStringNotContainsString(self::SECRET_VALUE, $output);
    }
}
