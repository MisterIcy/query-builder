<?php

namespace MisterIcy\QueryBuilder\Operations;

final class In extends AbstractOperation
{
    public function __construct(string $field, array $terms)
    {
        parent::__construct($field, $terms);
        $this->operator = 'IN';
    }

}