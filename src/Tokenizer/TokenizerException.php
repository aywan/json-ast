<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Tokenizer;

final class TokenizerException extends \Exception
{
    public static function unexpectedSymbol(string $input, int $index, int $line, int $column): self
    {
        $at = mb_substr($input, max(0, $index-5), 10);

        return new self("unexpected symbol at {$line}:{$column}: ...{$at}...");
    }

    public static function badString(string $input, int $index, int $line, int $column): self
    {
        $at = mb_substr($input, max(0, $index-5), 10);

        return new self("unexpected string symbol at {$line}:{$column}: ...{$at}...");
    }
}
