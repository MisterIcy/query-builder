<?php

namespace MisterIcy\QueryBuilder\Operations;

final class IsNull extends AbstractOperation
{
    /**
     * @param mixed $leftOperand
     */
    public function __construct($leftOperand)
    {
        $this->forbiddenTypes['right'] = [];
        parent::__construct($leftOperand, null);
        $this->operator = 'IS NULL';
    }
    public function __toString(): string
    {
        return sprintf('%s %s', strval($this->leftOperand), $this->operator);
    }
}
