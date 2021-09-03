<?php

namespace MisterIcy\QueryBuilder\Expressions;

class Select extends AbstractExpression
{
    use HintableTrait;

    /**
     * @var string[]|null
     */
    private ?array $fields;

    /**
     * @param array<string, string>|array<int, string>|null $fields
     */
    public function __construct(?array $fields = null)
    {
        $this->fields = $fields;
        $this->preSeparator = ' ';
        $this->postSeparator = ' ';
        parent::__construct(100);
    }

    public function __toString(): string
    {
        $builder = 'SELECT';

        if ($this->isStraightJoin()) {
            $builder .= ' STRAIGHT_JOIN';
        }

        if ($this->isSqlNoCache()) {
            $builder .= ' SQL_NO_CACHE';
        }
        if ($this->isSqlCache()) {
            $builder .= ' SQL_CACHE';
        }

        if (is_null($this->fields) || count($this->fields) == 0) {
            $builder .= ' *';
            return $builder;
        }

        $assoc = self::has_string_keys($this->fields);
        $builder .= $this->preSeparator;

        foreach ($this->fields as $key => $value) {
            $builder .= sprintf('`%s` `%s`', ($assoc) ? $key : $value, $value);
            $builder .= $this->separator;
        }

        if (str_ends_with($builder, $this->separator)) {
            $builder = rtrim($builder, $this->separator);
        }

        $builder .= $this->postSeparator;

        return $builder;
    }
}