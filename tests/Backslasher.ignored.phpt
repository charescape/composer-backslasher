<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

use Tester\Assert;

$io = new IOInterface;
$backslasher = new Charescape\ComposerBackslasher\Backslasher($io, ['A\\count', 'A\\PREG_SPLIT_NO_EMPTY']);

Assert::matchFile(
	__DIR__ . '/fixtures/test1.ignored.expected.php',
	$backslasher->processCode(file_get_contents(__DIR__ . '/fixtures/test1.php'))
);

Assert::matchFile(
	__DIR__ . '/fixtures/test2.ignored.expected.php',
	$backslasher->processCode(file_get_contents(__DIR__ . '/fixtures/test2.php'))
);
