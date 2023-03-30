<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Node;

final class ObjectNode extends AbstractNode
{
    public function hasProperty(string $name): bool
    {
        return isset($this->children[$name]);
    }

    public function getProperty(string $name): AbstractNode
    {
        return $this->children[$name];
    }

    /**
     * @return \Generator<string, AbstractNode>
     */
    public function each(): \Generator
    {
        foreach ($this->children as $name => $child) {
            yield $name => $child;
        }
    }

    /**
     * @return string[]
     */
    public function getAllPropertyNames(): array
    {
        return array_keys($this->children);
    }
}
