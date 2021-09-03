<?php

namespace MisterIcy\QueryBuilder\Operations;

final class Gte extends AbstractOperation
{
    public function __construct($leftOperand, $rightOperand)
    {
        parent::__construct($leftOperand, $rightOperand);
        $this->operator = '>=';
    }
}