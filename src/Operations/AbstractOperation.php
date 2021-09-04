<?php

namespace MisterIcy\QueryBuilder\Operations;

use MisterIcy\QueryBuilder\Expressions\AbstractExpression;

abstract class AbstractOperation extends AbstractExpression
{
    /**
     * @var mixed
     */
    protected $leftOperand;
    /**
     * @var mixed
     */
    protected $rightOperand;
    protected string $operator;

    /**
     * @param mixed $leftOperand
     * @param mixed $rightOperand
     */
    public function __construct($leftOperand, $rightOperand)
    {
        parent::__construct(0);
        $this->leftOperand = $leftOperand;
        $this->rightOperand = $rightOperand;
    }
    public function __toString(): string
    {
        return sprintf('%s %s %s', strval($this->leftOperand), $this->operator, strval($this->rightOperand));
    }

}