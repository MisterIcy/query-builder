<?php

namespace MisterIcy\QueryBuilder\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;

final class OrX extends AbstractOperation
{
    private const OR = ' OR ';

    /**
     * @param array<AbstractOperation> $operations
     */
    public function __construct(array $operations)
    {
        $this->forbiddenTypes = ['left' => [], 'right' => []];
        parent::__construct(null, null);
        $this->expressions = $operations;
        if ($this->count() === 0) {
            throw new InvalidArgumentException('OrX requires at least one operation');
        }
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $builder = '';
        foreach ($this->expressions as $operation) {
            $builder .= $operation . self::OR;
        }
        if (str_ends_with($builder, self::OR)) {
            $builder = rtrim($builder, self::OR);
        }
        return $builder;
    }
}
