<?php

namespace MisterIcy\QueryBuilder\Operations;

final class OrX extends AbstractOperation
{
    private const OR = ' OR ';
    /**
     * @var array<AbstractOperation>
     */
    private array $operations;

    /**
     * @param array<AbstractOperation> $operations
     */
    public function __construct(array $operations)
    {
        $this->forbiddenTypes = ['left' => [], 'right' => []];
        parent::__construct(null, null);
        $this->operations = $operations;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $builder = '';
        foreach ($this->operations as $operation) {
            $builder .= $operation . self::OR;
        }
        if (str_ends_with($builder, self::OR)) {
            $builder = rtrim($builder, self::OR);
        }
        return $builder;
    }

}