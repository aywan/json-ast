<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Node;

use Aywan\JsonAst\Tokenizer\Token;

abstract class AbstractNode
{
    protected Token $openToken;
    protected Token $closeToken;

    protected ?Token $identifier;

    /**
     * @var array<AbstractNode>
     */
    protected array $children;

    /** @var mixed */
    private $phpValue;

    public function __construct(
        Token $openToken,
        Token $closeToken,
        ?Token $identifier,
        array $children,
        $phpValue
    ) {
        $this->openToken = $openToken;
        $this->closeToken = $closeToken;
        $this->identifier = $identifier;
        $this->children = $children;
        $this->phpValue = $phpValue;
    }

    /**
     * @return Token|null
     */
    public function getIdentifier(): ?Token
    {
        return $this->identifier;
    }

    /**
     * @return Token
     */
    public function getOpenToken(): Token
    {
        return $this->openToken;
    }

    /**
     * @return Token
     */
    public function getCloseToken(): Token
    {
        return $this->closeToken;
    }

    /**
     * @return mixed
     */
    public function getPhpValue()
    {
        return $this->phpValue;
    }
}
