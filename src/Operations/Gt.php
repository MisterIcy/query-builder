<?php

namespace MisterIcy\QueryBuilder\Operations;

final class Gt extends AbstractOperation
{
    /**
     * @param mixed $leftOperand
     * @param mixed $rightOperand
     */
    public function __construct($leftOperand, $rightOperand)
    {
        parent::__construct($leftOperand, $rightOperand);
        $this->operator = '>';
    }
}
