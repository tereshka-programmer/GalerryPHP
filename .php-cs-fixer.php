<?php

use PhpCsFixer\Finder;

$rules = [
    '@PSR2' => true,
    'array_syntax' => ['syntax' => 'short'],
    'function_declaration' => ['closure_function_spacing' => 'none']
];

$projectPath = __DIR__;

$finder = Finder::create()
    ->in([
        $projectPath . '/app',
        $projectPath . '/config',
        $projectPath . '/database',
        $projectPath . '/resources',
        $projectPath . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();

return $config->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
