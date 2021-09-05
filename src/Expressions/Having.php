<?php

namespace MisterIcy\QueryBuilder\Expressions;

use MisterIcy\QueryBuilder\Operations\AbstractOperation;

class Having extends AbstractExpression
{
    private AbstractOperation $condition;

    public function __construct(AbstractOperation $condition)
    {
        parent::__construct(self::PRIORITY_HAVING);
        $this->condition = $condition;
    }
    public function __toString(): string
    {
        return sprintf('HAVING %s', strval($this->condition));
    }
}
