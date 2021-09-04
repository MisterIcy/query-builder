<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Expressions;

use MisterIcy\QueryBuilder\QueryBuilder;

/**
 * Class FromQuery.
 *
 * @license Apache-2.0
 * @package MisterIcy\QueryBuilder\Expressions
 * @since 1.0
 */
final class FromQuery extends From
{
    /**
     * Creates a new FROM Expression with a nested select as the table.
     *
     * @param QueryBuilder $builder
     * @param string $alias
     */
    public function __construct(QueryBuilder $builder, string $alias = 't')
    {
        $this->nested = true;
        $builder->setIsNested(true);
        parent::__construct(sprintf('(%s)', $builder->getQuery()), $alias);
    }
}