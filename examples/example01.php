<?php

declare(strict_types=1);

namespace AndreyRed\SecretValue\Example;

use function serialize;
use function unserialize;

require dirname(__DIR__) . '/vendor/autoload.php';

$acc1 = new BankAccount('111');
$accSame = new BankAccount('111');
$accAnother = new BankAccount('222');

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

$a = unserialize(serialize($acc1), [BankAccount::class]);

