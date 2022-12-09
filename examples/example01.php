<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\Example;

use function print_r;
use function serialize;
use function unserialize;
use function var_dump;

require dirname(__DIR__) . '/vendor/autoload.php';

$acc1 = new BankAccount('111111111111111');
$accSame = new BankAccount('111111111111111');
$accAnother = new BankAccount('222222222222222');

var_export([
    'acc1-obj' => $acc1,
    'acc1-str' => (string) $acc1,
    '-----',
    'first call' => $acc1->reveal(),
    'second call' => $acc1->reveal(),
    '-----',
    json_encode(['acc' => $acc1]),
    '-----',
    $acc1->reveal() === '111',
    '-----',
    'acc1-rel' => $acc1->reveal(),
    'acc-same' => $accSame->reveal(),
    'acc-another' => $accAnother->reveal(),
    '-----',
    'acc1 nad same' => $acc1->reveal() === $accSame->reveal(),
    'acc1 nad other' => $acc1->reveal() === $accAnother->reveal(),
    '-----',
    'acc1=same' => $acc1->equalsTo($accSame),
    'acc1=another' => $acc1->equalsTo($accAnother),
], false);

echo "\n\n==== var_dump ====\n\n";
/** @noinspection ForgottenDebugOutputInspection */
var_dump($acc1);

echo "\n\n==== print_r ====\n\n";
/** @noinspection ForgottenDebugOutputInspection */
print_r($acc1);
