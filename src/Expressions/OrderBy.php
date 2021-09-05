<?php

namespace MisterIcy\QueryBuilder\Expressions;

class OrderBy extends AbstractExpression
{
    /**
     * @var string[]
     */
    private array $ordering;

    /**
     * @param array<string, string> $ordering
     */
    public function __construct(array $ordering)
    {
        parent::__construct(self::PRIORITY_ORDER_BY);
        $this->ordering = $ordering;
    }

    public function __toString(): string
    {
        $builder = 'ORDER BY ';
        foreach ($this->ordering as $key => $item) {
            $builder .= sprintf("%s %s%s", $key, $item, $this->separator);
        }
        if (str_ends_with($builder, $this->separator)) {
            $builder = rtrim($builder, $this->separator);
        }
        return $builder;
    }
}
