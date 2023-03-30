<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Tokenizer;

final class Tokenizer
{
    private int $line;
    private int $column;
    private int $index;
    private int $maxIndex;

    private static array $symbolsTokenMap = [
        '{' => TokenType::LEFT_BRACE,
        '}' => TokenType::RIGHT_BRACE,
        '[' => TokenType::LEFT_BRACKET,
        ']' => TokenType::RIGHT_BRACKET,
        ':' => TokenType::COLON,
        ',' => TokenType::COMMA,
    ];

    private static array $keywordsTokenMap = [
        'true' => TokenType::TRUE,
        'false' => TokenType::FALSE,
        'null' => TokenType::NULL,
    ];

    /**
     * @param string $input
     * @return TokenData
     *
     * @throws TokenizerException
     */
    public function parse(string $input): TokenData
    {
        $this->line = 1;
        $this->column = 0;
        $this->index = 0;

        $tokens = new TokenData($input);

        $this->maxIndex = mb_strlen($input);
        while ($this->index < $this->maxIndex) {
            if ($this->skipWhitespace($input)) {
                continue;
            }

            $matched = $this->parseSymbol($input)
                ?? $this->parseKeyword($input)
                ?? $this->parseString($input)
                ?? $this->parseNumber($input);

            if ($matched === null) {
                throw TokenizerException::unexpectedSymbol(
                    $input,
                    $this->index,
                    $this->line,
                    $this->column,
                );
            }

            $tokens->addToken($matched);
        }

        return $tokens;
    }

    private function skipWhitespace(string $input): bool
    {
        if (mb_substr($input, $this->index, 1) === "\r") {
            $this->index++;
            $this->line++;
            $this->column = 0;
            if (mb_substr($input, $this->index, 1) === "\n") {
                $this->index++;
            }

            return true;
        }

        if (mb_substr($input, $this->index, 1) === "\n") {
            $this->index++;
            $this->line++;
            $this->column = 0;
            if (mb_substr($input, $this->index, 1) === "\r") {
                $this->index++;
            }

            return true;
        }

        if (mb_substr($input, $this->index, 1) === ' ' || mb_substr($input, $this->index, 1) === "\t") {
            $this->index++;
            $this->column++;

            return true;
        }

        return false;
    }

    private function parseSymbol(string $input): ?Token
    {
        $char = mb_substr($input, $this->index, 1);

        if (!isset(self::$symbolsTokenMap[$char])) {
            return null;
        }

        $token = Token::create(
            self::$symbolsTokenMap[$char],
            $char,
            $this->index,
            $this->line,
            $this->column,
            $this->column,
        );
        $this->index++;
        $this->column++;

        return $token;
    }

    private function parseKeyword(string $input): ?Token
    {
        $next = $this->findNextWhitespaceToken($input);

        $length = $next - $this->index;
        $value = mb_substr($input, $this->index, $length);
        if (!isset(self::$keywordsTokenMap[$value])) {
            return null;
        }

        $token = Token::create(
            self::$keywordsTokenMap[$value],
            $value,
            $this->index,
            $this->line,
            $this->column,
            $this->column + $length - 1,
        );

        $this->column += $length;
        $this->index = $next;

        return $token;
    }

    /**
     * @throws TokenizerException
     */
    private function parseString(string $input): ?Token
    {
        if (mb_substr($input, $this->index, 1) !== '"') {
            return null;
        }

        $idx = $this->index + 1;


        $escapes = ['"', '\\', '/', 'b', 'f', 'n', 'r', 't', 'u'];
        $isEscape = false;

        while ($idx < $this->maxIndex) {
            $char = mb_substr($input, $idx, 1);

            if ($isEscape) {
                if (in_array($char, $escapes, true)) {
                    $idx++;
                    if (mb_substr($input, $idx, 1) === 'u') {
                        for ($i = 0; $i < 4; $i++) {
                            $charOrd = ord(strtolower(mb_substr($input, $idx, 1)));
                            if ($charOrd < ord('0') || $charOrd > ord('a')) {
                                throw TokenizerException::badString($input, $idx, $this->line, $this->column);
                            }
                            $idx++;
                        }
                    }

                    $isEscape = false;
                } else {
                    throw TokenizerException::badString($input, $idx, $this->line, $this->column);
                }
            } else {
                if ($char === '\\') {
                    $idx++;
                    $isEscape = true;
                    continue;
                }

                if ($char === '"') {
                    $idx++;
                    break;
                }
                $idx++;
            }
        }

        $length = $idx - $this->index;
        $str = mb_substr($input, $this->index, $length);

        $token = Token::create(
            TokenType::STRING,
            $str,
            $this->index,
            $this->line,
            $this->column,
            $this->column + $length - 1,
        );

        $this->index = $idx;
        $this->column += $length;

        return $token;
    }

    private function parseNumber(string $input): ?Token
    {
        $next = $this->findNextWhitespaceToken($input);

        $length = $next - $this->index;
        $value = mb_substr($input, $this->index, $length);
        if (null === filter_var($value, FILTER_VALIDATE_INT | FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE)) {
            return null;
        }

        $token = Token::create(
            TokenType::NUMBER,
            $value,
            $this->index,
            $this->line,
            $this->column,
            $this->column + $length - 1,
        );

        $this->column += $length;
        $this->index = $next;

        return $token;
    }

    private function findNextWhitespaceToken(string $input): int
    {
        $i = $this->index;

        $stopSymbols = [" ", "\n", "\r", "\t", ",", ":", "]", "}"];
        while ($i < $this->maxIndex && !in_array(mb_substr($input, $i, 1), $stopSymbols, true)) {
            $i++;
        }

        return $i;
    }
}
