<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Node;

use Aywan\JsonAst\Tokenizer\Token;
use Aywan\JsonAst\Tokenizer\TokenData;
use Aywan\JsonAst\Tokenizer\TokenType;

final class TreeParser
{
    private int $index;
    private int $tokenCount;
    private TokenData $tokenData;

    /**
     * @param TokenData $tokenData
     * @return AbstractNode
     * @throws ParserException
     */
    public function createTree(TokenData $tokenData): AbstractNode
    {
        $tokens = $tokenData->getTokens();
        $this->index = 0;
        $this->tokenCount = count($tokens);
        $this->tokenData = $tokenData;

        try {
            $tree = $this->parse($tokens);
        } finally {
            unset($this->tokenData);
        }

        if (null === $tree) {
            throw ParserException::emptyTree();
        }


        return $tree;
    }

    /**
     * @param array<Token> $tokens
     * @param Token|null $identifier
     * @return AbstractNode
     * @throws ParserException
     */
    private function parse(array $tokens, ?Token $identifier = null): ?AbstractNode
    {
        if ($this->index >= $this->tokenCount) {
            return null;
        }

        return $this->parseObject($tokens, $identifier)
            ?? $this->parseArray($tokens, $identifier)
            ?? $this->parseScalar($tokens, $identifier)
        ;
    }

    /**
     * @param array<Token> $tokens
     * @param Token|null $identifier
     *
     * @return AbstractNode|null
     * @throws \JsonException
     * @throws ParserException
     */
    private function parseObject(array $tokens, ?Token $identifier = null): ?AbstractNode
    {
        if (! $tokens[$this->index]->isType(TokenType::LEFT_BRACE)) {
            return null;
        }
        $openToken = $tokens[$this->index];
        $this->index++;

        $children = [];

        while ($this->index < $this->tokenCount) {
            $propertyIdentifier = $tokens[$this->index];
            if ($tokens[$this->index]->isType(TokenType::RIGHT_BRACE)) {
                break;
            }
            if (! $propertyIdentifier->isType(TokenType::STRING)) {
                throw ParserException::expectedStringToken($propertyIdentifier);
            }
            $this->index++;
            if ($this->index >= $this->tokenCount || ! $tokens[$this->index]->isType(TokenType::COLON)) {
                throw ParserException::unexpectedTokenType($tokens[$this->index] ?? null, ':');
            }
            $this->index++;

            $propStringName = json_decode($propertyIdentifier->value, true, 512, \JSON_THROW_ON_ERROR);
            $children[$propStringName] = $this->parse($tokens, $propertyIdentifier);

            if (! $tokens[$this->index]->isType(TokenType::COMMA)) {
                break;
            }
            $this->index++;
        }

        if ($this->index >= $this->tokenCount || ! $tokens[$this->index]->isType(TokenType::RIGHT_BRACE)) {
            throw ParserException::unexpectedTokenType($tokens[$this->index] ?? null, '}');
        }
        $closeToken = $tokens[$this->index];
        $this->index++;

        $raw = $this->tokenData->getRawBetween($openToken, $closeToken);
        return new ObjectNode(
            $openToken,
            $closeToken,
            $identifier,
            $children,
            json_decode($raw, true, 512, \JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @param array<Token> $tokens
     * @param Token|null $identifier
     *
     * @return AbstractNode|null
     * @throws \JsonException
     */
    private function parseArray(array $tokens, ?Token $identifier = null): ?AbstractNode
    {
        if (! $tokens[$this->index]->isType(TokenType::LEFT_BRACKET)) {
            return null;
        }
        $openToken = $tokens[$this->index];
        $this->index++;

        $children = [];
        while ($this->index < $this->tokenCount) {
            $children[] = $this->parse($tokens);

            if ($this->index >= $this->tokenCount) {
                throw ParserException::unexpectedEnd();
            }

            if (! $tokens[$this->index]->isType(TokenType::COMMA)) {
                break;
            }
            $this->index++;
        }

        if ($this->index >= $this->tokenCount || ! $tokens[$this->index]->isType(TokenType::RIGHT_BRACKET)) {
            throw ParserException::unexpectedTokenType($tokens[$this->index] ?? null, ']');
        }
        $closeToken = $tokens[$this->index];
        $this->index++;

        $raw = $this->tokenData->getRawBetween($openToken, $closeToken);
        return new ArrayNode(
            $openToken,
            $closeToken,
            $identifier,
            $children,
            json_decode($raw, true, 512, \JSON_THROW_ON_ERROR)
        );
    }

    /**
     * @param array<Token> $tokens
     * @param Token|null $identifier
     *
     * @return AbstractNode|null
     * @throws \JsonException
     */
    private function parseScalar(array $tokens, ?Token $identifier = null): ?AbstractNode
    {
        $token = $tokens[$this->index];
        if (! $token->isType(TokenType::NUMBER, TokenType::STRING, TokenType::NULL, TokenType::FALSE, TokenType::TRUE)) {
            return null;
        }
        $this->index++;

        $value = json_decode($token->value, true, 512, \JSON_THROW_ON_ERROR);

        return new ScalarNode(
            $token,
            $token,
            $identifier,
            [$token],
            $value
        );
    }
}
