<?php

namespace MisterIcy\QueryBuilder\Operations;

final class Like extends AbstractOperation
{
    public function __construct(string $field, string $term)
    {
        parent::__construct($field, $term);
        $this->operator = 'LIKE';
    }
}