<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Expressions;

/**
 * Class Select.
 *
 * Creates a SELECT Statement.
 *
 * @license Apache-2.0
 * @package MisterIcy\QueryBuilder\Expressions
 * @since 1.0
 */
class Select extends AbstractExpression
{
    /**
     * An array of hints for the SELECT clause.
     *
     * @var string[]
     */
    protected array $hints = [];
    /**
     * An array of fields to be selected.
     *
     * @var string[]|null
     */
    private ?array $fields;

    /**
     * Creates a new SELECT expression.
     *
     * @param array<string, string>|array<int, string>|null $fields An array or fields or null if you want to SELECT *.
     * If you pass an associative array with keys and values, the keys will become the fields to be selected, while the
     * values will become their aliases.
     */
    public function __construct(?array $fields = null)
    {
        $this->fields = $fields;
        $this->preSeparator = ' ';
        $this->postSeparator = ' ';
        parent::__construct(self::PRIORITY_SELECT);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $builder = 'SELECT' . $this->injectHints();

        if (is_null($this->fields) || count($this->fields) === 0) {
            $builder .= ' *';
            return $builder;
        }

        $builder .= $this->postSeparator;
        $assoc = self::hasStringKeys($this->fields);

        foreach ($this->fields as $key => $value) {
            $builder .= sprintf('`%s` `%s`', ($assoc) ? $key : $value, $value);
            $builder .= $this->separator;
        }

        if (str_ends_with($builder, $this->separator)) {
            $builder = rtrim($builder, $this->separator);
        }

        return $builder;
    }

    private function injectHints(): string
    {
        if (count($this->getHints()) > 0) {
            return sprintf(' %s', rtrim(implode(' ', $this->hints)));
        }
        return '';
    }

    /**
     * Returns the hints to be used.
     *
     * @return string[]
     */
    public function getHints(): array
    {
        return $this->hints;
    }

    /**
     * Sets the hints for the SELECT expression.
     *
     * Note that there are no internal checks here. You should only set hints that are acceptable by the RDBMS (i.e.
     * you can add SQL_NO_CACHE and SQL_CACHE, but the query will break).
     *
     * @param string[] $hints An array of hints for the SQL Optimizer.
     * @return self
     */
    public function setHints(array $hints = []): self
    {
        $this->hints = $hints;
        return $this;
    }
}
