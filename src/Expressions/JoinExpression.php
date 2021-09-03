<?php

namespace MisterIcy\QueryBuilder\Expressions;

abstract class JoinExpression extends AbstractExpression
{
    public function __construct(int $priority = 0)
    {
        parent::__construct($priority);
    }
}