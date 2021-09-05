<?php

declare(strict_types=1);

namespace MisterIcy\QueryBuilder\Expressions;

/**
 * Class InsertInto
 *
 * @license Apache-2.0
 * @since 0.2.0
 * @package MisterIcy\QueryBuilder\Expressions
 */
class InsertInto extends AbstractExpression
{
    use HintableExpressionTrait;

    private string $table;
    /**
     * @var array<int, string>|array<string, string>
     */
    private array $values;

    /**
     * @param string $table
     * @param array<int, string>|array<string, mixed> $values
     */
    public function __construct(string $table, array $values)
    {
        parent::__construct(self::PRIORITY_SELECT);
        $this->table = $table;
        $this->values = $values;
    }

    public function __toString(): string
    {
        $builder = 'INSERT' . $this->injectHints();

        $builder .= sprintf(' INTO `%s` %s', $this->table, $this->preSeparator);
        $assoc = self::hasStringKeys($this->values);

        if (!$assoc) {
            $builder .= implode($this->separator, $this->values);
        } else {
            $builder .= implode($this->separator, array_keys($this->values));
        }

        $builder .= sprintf('%s VALUES %s', $this->postSeparator, $this->preSeparator);

        if (!$assoc) {
            $builder .= ':' . implode(', :', $this->values);
        } else {
            $builder .= implode($this->separator, $this->values);
        }

        $builder .= $this->postSeparator;

        return $builder;
    }


    protected function injectHints(): string
    {
        if (count($this->getHints()) > 0) {
            return sprintf(' %s', rtrim(implode(' ', $this->hints)));
        }
        return '';
    }
}
