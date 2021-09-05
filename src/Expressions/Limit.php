<?php

namespace MisterIcy\QueryBuilder\Expressions;

final class Limit extends AbstractExpression
{
    private int $limit;
    private ?int $offset;

    public function __construct(int $limit, ?int $offset = null)
    {
        parent::__construct(self::PRIORITY_LIMIT);
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function __toString(): string
    {
        $builder = 'LIMIT ';
        if (!is_null($this->offset)) {
            $builder .= $this->offset . ", ";
        }
        $builder .= $this->limit;

        return $builder;
    }

}