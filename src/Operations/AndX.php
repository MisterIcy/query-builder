<?php

namespace MisterIcy\QueryBuilder\Operations;

final class AndX extends AbstractOperation
{
    private const AND = ' AND ';
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
    public function __toString() :string
    {
        $builder = '';
        foreach ($this->operations as $operation) {
            $builder .= strval($operation) . self::AND;
        }
        if (str_ends_with($builder, self::AND)) {
            $builder = rtrim($builder, self::AND);
        }
        return $builder;
    }

}