<?php

namespace MisterIcy\QueryBuilder\Operations;

final class IsNotNull extends AbstractOperation
{
    /**
     * @param mixed $leftOperand
     */
    public function __construct($leftOperand)
    {
        $this->forbiddenTypes['right'] = [];
        parent::__construct($leftOperand, null);
        $this->operator = 'IS NOT NULL';
    }
    public function __toString(): string
    {
        return sprintf('%s %s', strval($this->leftOperand), $this->operator);
    }
}
