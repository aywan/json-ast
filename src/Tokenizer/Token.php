<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Tokenizer;

final class Token
{
    public int $type;
    public string $value;
    public int $index;
    public int $line;
    public int $startColumn;
    public int $endColumn;

    public static function create(int $type, string $value, int $index, int $line, int $startColumn, int $endColumn): self
    {
        $token = new self();

        $token->type = $type;
        $token->value = $value;
        $token->index = $index;
        $token->line = $line;
        $token->startColumn = $startColumn;
        $token->endColumn = $endColumn;

        return $token;
    }
}
