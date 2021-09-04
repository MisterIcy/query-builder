<?php

namespace MisterIcy\QueryBuilder\Expressions;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;

class Where extends AbstractExpression
{
    private AbstractExpression $expression;
    private bool $isAnd;
    private bool $isOr;

    public function __construct(AbstractExpression $expression, bool $isAnd = false, bool $isOr = false)
    {
        parent::__construct(50);
        if ($expression instanceof Where) {
            throw new InvalidArgumentException('You cannot use a WHERE expression inside a WHERE expression');
        }
        $this->expression = $expression;
        $this->isAnd = $isAnd;
        $this->isOr = $isOr;
        if ($this->isAnd || $this->isOr) {
            $this->priority = 45;
        }
    }

    public function __toString(): string
    {
        $builder = '';
        if ($this->isAnd) {
            $builder .= 'AND ';
        } elseif ($this->isOr) {
            $builder .= 'OR ';
        } else {
            $builder .= 'WHERE ';
        }

        $builder .= strval($this->expression);

        return $builder;
    }
}
