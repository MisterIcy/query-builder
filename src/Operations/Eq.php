<?php

namespace MisterIcy\QueryBuilder\Operations;

final class Eq extends AbstractOperation
{
    public function __construct($left, $right)
    {
        parent::__construct($left, $right);
        $this->operator = '=';
    }

}