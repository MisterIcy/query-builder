<?php

namespace MisterIcy\QueryBuilder\BuilderTraits;

use MisterIcy\QueryBuilder\Expressions\ForceIndex;
use MisterIcy\QueryBuilder\Expressions\IgnoreIndex;
use MisterIcy\QueryBuilder\Expressions\UseIndex;

trait IndexTrait
{
    use BuilderTrait;

    /**
     * @param string[] $indices
     * @return self
     */
    public function useIndex(array $indices): self
    {
        return $this->addExpression(new UseIndex($indices));
    }

    /**
     * @param string[] $indices
     * @return self
     */
    public function forceIndex(array $indices): self
    {
        return $this->addExpression(new ForceIndex($indices));
    }

    /**
     * @param string[] $indices
     * @return self
     */
    public function ignoreIndex(array $indices): self
    {
        return $this->addExpression(new IgnoreIndex($indices));
    }
}
