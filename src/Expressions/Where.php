<?php

namespace MisterIcy\QueryBuilder\Expressions;

class Where extends AbstractExpression
{
    private AbstractExpression $expression;
    private bool $isAnd;
    private bool $isOr;

    public function __construct(AbstractExpression $expression, bool $isAnd = false, bool $isOr = false)
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
            $builder .= 'AND' . $this->preSeparator;
        } elseif ($this->isOr) {
            $builder .= 'OR' . $this->preSeparator;
        } else {
            $builder .= 'WHERE ';
        }

        $builder .= strval($this->expression);

        if ($this->isOr || $this->isAnd) {
            $builder .= $this->postSeparator;
        }
        return $builder;
    }
}
