<?php

namespace MisterIcy\QueryBuilder\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Exceptions\NullArgumentException;

final class Eq extends AbstractOperation
{
    /**
     * @param mixed $leftOperand
     * @param mixed $rightOperand
     */
    public function __construct($leftOperand, $rightOperand)
    {
        if (is_null($leftOperand) || is_null($rightOperand)) {
            throw new NullArgumentException();
        }
        if (is_object($leftOperand) || is_object($rightOperand) || is_array($leftOperand) || is_array($rightOperand)) {
            throw new InvalidArgumentException();
        }
        parent::__construct($leftOperand, $rightOperand);
        $this->operator = '=';
    }

}