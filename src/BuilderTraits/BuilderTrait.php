<?php

namespace MisterIcy\QueryBuilder\BuilderTraits;

use MisterIcy\QueryBuilder\Exceptions\IndexDirectiveAlreadyExistsException;
use MisterIcy\QueryBuilder\Expressions\AbstractExpression;
use MisterIcy\QueryBuilder\Expressions\IndexExpression;

trait BuilderTrait
{
    /**
     * @var AbstractExpression[]
     */
    protected array $expressions;

    private bool $hasIndex = false;

    public function addExpression(AbstractExpression $expression): self
    {
        if ($expression instanceof IndexExpression) {
            $this->setIndex();
        }
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
}
