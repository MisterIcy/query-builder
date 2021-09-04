<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Expressions;

/**
 * Class From.
 *
 * @license Apache-2.0
 * @package MisterIcy\QueryBuilder\Expressions
 * @since 1.0
 */
class From extends AbstractExpression
{
    /**
     * The name of the table to fetch data from.
     * @var string
     */
    private string $table;

    /**
     * The alias of the table (defaults to `t`)
     * @var string
     */
    private string $alias;

    protected bool $nested = false;

    /**
     * Creates a new FROM expression.
     *
     * @param string $table The name of the table to fetch data from.
     * @param string $alias The alias of the table (defaults to `t`).
     */
    public function __construct(string $table, string $alias)
    {
        parent::__construct(self::PRIORITY_FROM);
        $this->table = $table;
        $this->alias = $alias;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        if (!$this->nested) {
            $this->table = sprintf('`%s`', $this->table);
        }
        return sprintf('FROM %s `%s`', $this->table, $this->alias);
    }
}