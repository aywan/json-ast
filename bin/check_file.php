#!/usr/bin/env php
<?php

declare(strict_types=1);

use Aywan\JsonAst\JsonAstParser;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$parser = new JsonAstParser();

for ($i = 1; $i < $argc; $i++) {
    $path = $argv[$i];
    if (! is_file($path) || ! is_readable($path)) {
        throw new \Exception('invalid file path');
    }

    $content = file_get_contents($path);
    $tree = $parser->parse($content);

    var_dump($tree->getRoot());
}


