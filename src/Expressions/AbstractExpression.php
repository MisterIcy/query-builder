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
    protected const PRIORITY_BEGIN_TRANSACTION = 200;
    protected const PRIORITY_INSERT = 110;
    protected const PRIORITY_SELECT = 100;
    protected const PRIORITY_FROM = 90;
    protected const PRIORITY_INDEX = 85;
    protected const PRIORITY_JOIN = 80;
    protected const PRIORITY_GROUP_BY = 40;
    protected const PRIORITY_HAVING = 30;
    protected const PRIORITY_ORDER_BY = 20;
    protected const PRIORITY_LIMIT = -10;

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

    /**
     * Converts the expression into a string.
     * @return string
     */
    abstract public function __toString(): string;

    /**
     * @param array<mixed> $array
     * @return bool
     */
    final protected static function hasStringKeys(array $array): bool
    {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }
}
