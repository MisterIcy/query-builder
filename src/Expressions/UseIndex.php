<?php

namespace MisterIcy\QueryBuilder\Expressions;

final class UseIndex extends IndexExpression
{
    public function __construct(array $indices)
    {
        parent::__construct($indices);
    }
}