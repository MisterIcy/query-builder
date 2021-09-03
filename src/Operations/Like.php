<?php

namespace MisterIcy\QueryBuilder\Operations;

final class Like extends AbstractOperation
{
    /**
     * @param string $field
     * @param string $term
     */
    public function __construct(string $field, string $term)
    {
        parent::__construct($field, $term);
        $this->operator = 'LIKE';
    }
}