<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('tests/_support')
;

$safeRules = require_once __DIR__.'/.php-cs-fixer-safe.php';

// Risky rules are checked in CI automatically. Also they checked in pre-commit hook.
$riskyRules = [
    'is_null' => true, // risky if is_null is overridden
    'declare_strict_types' => true,
    'date_time_immutable' => true, // use DateTimeImmutable instead of DateTime
];

return (new PhpCsFixer\Config())
    ->setRules(array_merge($safeRules, $riskyRules))
    ->setFinder($finder)
    ->setRiskyAllowed(true);
