<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Tokenizer;

final class TokenData
{
    private array $tokens = [];

    private string $raw;

    public function __construct(string $raw)
    {
        $this->raw = $raw;
    }

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

    /**
     * @return string
     */
    public function getRaw(): string
    {
        return $this->raw;
    }

    public function getRawBetween(Token $from, Token $to): string
    {
        if ($from->index > $to->index) {
            throw new \Exception('from index greater then to index');
        }

        $startIndex = $from->index;
        $endIndex = $to->index + $to->endColumn - $to->startColumn + 1;

        return mb_substr($this->raw, $startIndex, $endIndex - $startIndex);
    }
}
