<?php

namespace MisterIcy\QueryBuilder\Expressions;

class Select extends AbstractExpression
{
    /**
     * An array of hints for the SELECT clause.
     *
     * @var string[]
     */
    protected array $hints = [];
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
        parent::__construct(self::PRIORITY_SELECT);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        $builder = 'SELECT ';

        if (count($this->hints) > 0) {
            $builder .= rtrim(implode(' ', $this->hints));
        }

        if (is_null($this->fields) || count($this->fields) == 0) {
            $builder .= '*';
            return $builder;
        }

        $builder .= $this->postSeparator;
        $assoc = self::has_string_keys($this->fields);

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

    /**
     * @return string[]
     */
    public function getHints(): array
    {
        return $this->hints;
    }

    /**
     * @param string[] $hints
     * @return self
     */
    public function setHints(array $hints = []): self
    {
        $this->hints = $hints;
        return $this;
    }
}
