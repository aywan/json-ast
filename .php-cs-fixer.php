<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude(['.idea', 'vendor', 'tools'])
    ->in(__DIR__)
;

$config = new PhpCsFixer\Config();
$config
    ->setRules([
        '@PER' => true,
    ])
    ->setFinder($finder)
;

return $config;