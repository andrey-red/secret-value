<?php

declare(strict_types=1);

use AndreyRed\SecretValue\example\BankAccount;
use AndreyRed\SecretValue\example\Passport;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

$acc1 = new BankAccount('111');
$accSame = new BankAccount('111');
$accAnother = new BankAccount('222');

var_export([
//    'acc1' => $acc1,
//    'acc2' => $acc2,
//    'acc1-str' => (string )$acc1,
//    'acc2-str' => (string )$acc2,
//    'acc1-obj' => $acc1,
//    'acc1-str' => (string) $acc1,
//    $acc1->reveal(),
//    $acc1->reveal(),
//    '-----',
    $acc1->reveal() === '111',
    '-----',
    'acc1' => $acc1->reveal(),
    'acc-same' => $accSame->reveal(),
    'acc-another' => $accAnother->reveal(),
    '-----',
    'acc1 nad same' => $acc1->reveal() === $accSame->reveal(),
    'acc1 nad other' => $acc1->reveal() === $accAnother->reveal(),
    '-----',
    'acc1=same' => $acc1->equalTo($accSame),
    'acc1=another' => $acc1->equalTo($accAnother),
], false);
