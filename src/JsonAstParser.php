<?php

declare(strict_types=1);

namespace Aywan\JsonAst;

use Aywan\JsonAst\Node\TreeParser;
use Aywan\JsonAst\Tokenizer\Tokenizer;

final class JsonAstParser
{
    private Tokenizer $tokenizer;
    private TreeParser $treeParser;

    public function __construct()
    {
        $this->tokenizer = new Tokenizer();
        $this->treeParser = new TreeParser();
    }

    public function parse(string $json): JsonAstTree
    {
        $tokens = $this->tokenizer->parse($json);
        $rootNode = $this->treeParser->createTree($tokens);

        return new JsonAstTree($tokens, $rootNode);
    }
}
