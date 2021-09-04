<?php

namespace MisterIcy\QueryBuilder\Expressions;

use MisterIcy\QueryBuilder\Operations\AbstractOperation;

class Where extends AbstractExpression
{
    private AbstractOperation $expression;
    private bool $isAnd;
    private bool $isOr;

    public function __construct(AbstractOperation $expression, bool $isAnd = false, bool $isOr = false)
    {
        parent::__construct(50);
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

        $builder .= $this->expression;

        return $builder;
    }
}
