<?php

namespace MisterIcy\QueryBuilder\Expressions;

final class ForceIndex extends IndexExpression
{
    public function __construct(array $indices)
    {
        parent::__construct($indices);
        $this->action = 'FORCE';
    }
}