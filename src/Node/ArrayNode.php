<?php

declare(strict_types=1);

namespace Aywan\JsonAst\Node;

/**
 * @implements \ArrayAccess<int, AbstractNode>
 */
final class ArrayNode extends AbstractNode implements \ArrayAccess, \Countable
{
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->children);
    }

    public function offsetGet($offset)
    {
        return $this->children[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new \Exception("unable to set value");
    }

    public function offsetUnset($offset)
    {
        throw new \Exception("unable to unset value");
    }

    public function count()
    {
        return count($this->children);
    }
}
