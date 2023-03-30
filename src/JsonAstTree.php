<?php

declare(strict_types=1);

namespace Aywan\JsonAst;

use Aywan\JsonAst\Node\AbstractNode;
use Aywan\JsonAst\Tokenizer\TokenData;

final class JsonAstTree
{
    private TokenData $tokens;
    private AbstractNode $root;

    public function __construct(TokenData $tokens, AbstractNode $root)
    {
        $this->tokens = $tokens;
        $this->root = $root;
    }

    /**
     * @return TokenData
     */
    public function getTokens(): TokenData
    {
        return $this->tokens;
    }

    /**
     * @return AbstractNode
     */
    public function getRoot(): AbstractNode
    {
        return $this->root;
    }
}
