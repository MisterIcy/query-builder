<?php

namespace MisterIcy\QueryBuilder\Operations;

final class Lte extends AbstractOperation
{
    public function __construct($leftOperand, $rightOperand)
    {
        parent::__construct($leftOperand, $rightOperand);
        $this->operator = '<=';
    }
}