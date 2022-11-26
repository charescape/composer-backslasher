<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

use Tester\Assert;

$io = new IOInterface;
$backslasher = new Charescape\ComposerBackslasher\Backslasher($io);

for ($i = 1; $i <= 4; $i++) {
	Assert::matchFile(
		__DIR__ . "/fixtures/test{$i}.expected.php",
		$backslasher->processCode(file_get_contents(__DIR__ . "/fixtures/test{$i}.php"))
	);
}
