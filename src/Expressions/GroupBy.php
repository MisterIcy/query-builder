<?php

namespace MisterIcy\QueryBuilder\Expressions;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;

class GroupBy extends AbstractExpression
{
    /**
     * @var string[]
     */
    private array $fields;

    /**
     * @param string[] $fields
     * @throws InvalidArgumentException
     */
    public function __construct(array $fields)
    {
        if (count($fields) == 0) {
            throw new InvalidArgumentException("GROUP BY requires at least one field");
        }
        $this->fields = $fields;
        parent::__construct(self::PRIORITY_GROUP_BY);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return sprintf('GROUP BY %s', implode(',', $this->fields));
    }
}
