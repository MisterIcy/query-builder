<?php

namespace MisterIcy\QueryBuilder\Expressions;

/**
 * Trait HintableExpressionTrait.
 *
 * @license Apache-2.0
 * @since 0.2.0
 * @package MisterIcy\QueryBuilder\Expressions
 */
trait HintableExpressionTrait
{
    /**
     * An array of hints for the SELECT clause.
     *
     * @since 0.2.0
     * @var string[]
     */
    protected array $hints = [];

    /**
     * Returns the hints to be used.
     *
     * @return string[]
     * @since 0.2.0
     */
    public function getHints(): array
    {
        return $this->hints;
    }

    /**
     * Sets the hints for the expression.
     *
     * Note that there are no internal checks here. You should only set hints that are acceptable by the RDBMS (i.e.
     * you can add SQL_NO_CACHE and SQL_CACHE, but the query will break).
     *
     * @param string[] $hints An array of hints for the SQL Optimizer.
     * @return self
     * @since 0.2.0
     */
    public function setHints(array $hints = []): self
    {
        $this->hints = $hints;
        return $this;
    }

    abstract protected function injectHints(): string;
}
