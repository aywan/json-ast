<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Tokenizer;

use Aywan\JsonAst\JsonAstException;

final class TokenizerException extends JsonAstException
{
    public static function unexpectedSymbol(string $input, int $index, int $line, int $column): self
    {
        $s = mb_substr($input, $index, 1);
        $at = mb_substr($input, max(0, $index - 10), 20);

        return new self("unexpected symbol '{$s}' at {$line}:{$column} ({$index}): ...{$at}...");
    }

    public static function badString(string $input, int $index, int $line, int $column): self
    {
        $s = mb_substr($input, $index, 1);
        $at = mb_substr($input, max(0, $index - 10), 20);

        return new self("unexpected string symbol '{$s}' at {$line}:{$column} ({$index}): ...{$at}...");
    }
}
