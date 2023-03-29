<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Tokenizer;

final class TokenList
{
    private array $tokens = [];

    public function addToken(Token $token): self
    {
        $this->tokens[] = $token;

        return $this;
    }

    /**
     * @return array<Token>
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }
}
