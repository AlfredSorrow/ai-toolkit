<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('tests/_support');

$safeRules = require_once __DIR__.'/.php-cs-fixer-safe.php';

// Safe rules applied on commit
return (new PhpCsFixer\Config())
    ->setRules($safeRules)
    ->setFinder($finder);
