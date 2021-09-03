<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Expressions;

class Delete extends AbstractExpression
{
    private string $table;
    private string $alias;
    private bool $ignore = false;

    /**
     * @return bool
     */
    public function isIgnore(): bool
    {
        return $this->ignore;
    }

    /**
     * @param bool $ignore
     */
    public function setIgnore(bool $ignore): void
    {
        $this->ignore = $ignore;
    }

    public function __construct(string $table, string $alias = 't')
    {
        parent::__construct(100);
        $this->table = $table;
        $this->alias = $alias;
    }

    public function __toString(): string
    {
        $builder = 'DELETE ';
        $builder .= ($this->ignore) ? 'IGNORE ': '';
        $builder .= sprintf('FROM `%s` `%s`', $this->table, $this->alias);
        return $builder;
    }
}