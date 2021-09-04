<?php

namespace MisterIcy\QueryBuilder\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;

final class AndX extends AbstractOperation
{
    private const AND = ' AND ';

    /**
     * @param array<AbstractOperation> $operations
     */
    public function __construct(array $operations)
    {
        $this->forbiddenTypes = ['left' => [], 'right' => []];
        parent::__construct(null, null);
        $this->expressions = $operations;
        if ($this->count() === 0) {
            throw new InvalidArgumentException('AndX requires at least one operation');
        }
    }

    /**
     * @inheritDoc
     */
    public function __toString() :string
    {
        $builder = '';
        foreach ($this->expressions as $operation) {
            $builder .= strval($operation) . self::AND;
        }
        if (str_ends_with($builder, self::AND)) {
            $builder = rtrim($builder, self::AND);
        }
        return $builder;
    }

}