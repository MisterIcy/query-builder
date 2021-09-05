<?php

namespace MisterIcy\QueryBuilder\BuilderTraits;

use MisterIcy\QueryBuilder\Exceptions\IndexDirectiveAlreadyExistsException;
use MisterIcy\QueryBuilder\Exceptions\QueryBuilder\JoinWithoutFromException;
use MisterIcy\QueryBuilder\Expressions\AbstractExpression;
use MisterIcy\QueryBuilder\Expressions\From;
use MisterIcy\QueryBuilder\Expressions\IndexExpression;
use MisterIcy\QueryBuilder\Expressions\InsertInto;
use MisterIcy\QueryBuilder\Expressions\Join\JoinExpression;
use MisterIcy\QueryBuilder\Expressions\Select;

trait BuilderTrait
{
    /**
     * @var AbstractExpression[]
     */
    protected array $expressions;

    private bool $hasIndex = false;

    /**
     * Defines the current operation. Defaults to null for no operation defined.
     *
     * @since 0.2.0
     * @var string|null
     */
    protected ?string $currentOperation = null;

    /**
     * Checks if an operation has started.
     *
     * @return bool true, if an operation is already defined, otherwise false
     * @since 0.2.0
     */
    protected function hasOperation(): bool
    {
        return !is_null($this->currentOperation);
    }

    public function addExpression(AbstractExpression $expression): self
    {
        if ($expression instanceof IndexExpression) {
            $this->setIndex();
        }
        $this->setOperation($expression)
            ->validateJoin($expression);
        $this->expressions[] = $expression;
        return $this;
    }

    protected function setIndex(): void
    {
        if ($this->hasIndex) {
            throw new IndexDirectiveAlreadyExistsException();
        }
        $this->hasIndex = true;
    }

    protected function setOperation(AbstractExpression $expression): self
    {
        if ($expression instanceof Select) {
            $this->currentOperation = self::OPERATION_SELECT;
        }
        if ($expression instanceof InsertInto) {
            $this->currentOperation = self::OPERATION_INSERT;
        }

        return $this;
    }

    /**
     * Disallow the user to perform a JOIN operation if FROM is not specified.
     *
     * @param AbstractExpression $expression The expression to be evaluated
     * @since 0.2.0
     * @return self
     * @throws JoinWithoutFromException When a JOIN expression is specified without specifying a FROM expression.
     */
    protected function validateJoin(AbstractExpression $expression): self
    {
        if (!($expression instanceof JoinExpression)) {
            return $this;
        }

        if (!$this->hasFrom()) {
            throw new JoinWithoutFromException();
        }

        return $this;
    }

    /**
     * Checks if a FROM expression exists in the QueryBuilder
     * @return bool
     */
    private function hasFrom(): bool
    {
        foreach ($this->expressions as $expression) {
            if ($expression instanceof From) {
                return true;
            }
        }
        return false;
    }
}
