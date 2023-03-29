<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Tokenizer;

final class TokenType
{
    public const LEFT_BRACE = 0;	// {
    public const RIGHT_BRACE = 1;	// }
    public const LEFT_BRACKET = 2;	// [
    public const RIGHT_BRACKET = 3;	// ]
    public const COLON = 4;			// :
    public const COMMA = 5;			// ,
    public const STRING = 6;		// "a"
    public const NUMBER = 7;		// 123e-3
    public const TRUE = 8;			// true
    public const FALSE = 9;			// false
    public const NULL = 10;			// null
}
