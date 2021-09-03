<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Expressions;

use Countable;

/**
 * Class AbstractExpression.
 *
 * @license Apache-2.0
 * @since 1.0
 * @package MisterIcy\QueryBuilder\Expressions
 */
abstract class AbstractExpression implements Countable
{
    protected string $preSeparator = '(';
    protected string $separator = ", ";
    protected string $postSeparator = ")";
    /**
     * @var array<AbstractExpression>
     */
    protected array $expressions;

    protected int $priority = 0;

    protected function __construct(int $priority = 0)
    {
        $this->priority = $priority;
        $this->expressions = [];
    }

    final public function count()
    {
        return count($this->expressions);
    }

    public function getPriority(): int
    {
        return $this->priority;
    }


    abstract public function __toString(): string;

    /**
     * @param array<mixed> $array
     * @return bool
     */
    final protected static function has_string_keys(array $array): bool
    {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }
}