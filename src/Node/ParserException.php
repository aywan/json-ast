<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Node;

use Aywan\JsonAst\JsonAstException;
use Aywan\JsonAst\Tokenizer\Token;

final class ParserException extends JsonAstException
{
    public static function emptyTree(): self
    {
        return new self("empty tree");
    }

    public static function unexpectedEnd(): self
    {
        return new self("unexpected end");
    }

    public static function expectedStringToken(Token $token): ParserException
    {
        return new self('expected string property identifier, got: ' . $token->value);
    }

    public static function unexpectedTokenType(?Token $token, string $expected = null): self
    {
        $msg = 'unexpected token'
            . ($expected ? ', expect `${expected}`' : '')
            . ', got: ' . ($token->value ?? 'EOF')
        ;
        return new self($msg);
    }
}