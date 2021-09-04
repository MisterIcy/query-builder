<?php

namespace MisterIcy\QueryBuilder\Expressions;

abstract class IndexExpression extends AbstractExpression
{
    protected string $action = 'USE';
    /**
     * @var string[]
     */
    protected array $indices;

    /**
     * @param string[] $indices
     */
    public function __construct(array $indices)
    {
        parent::__construct(self::PRIORITY_INDEX);
        $this->indices = $indices;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s INDEX %s%s%s',
            $this->action,
            $this->preSeparator,
            implode(',', $this->indices),
            $this->postSeparator
        );
    }

}