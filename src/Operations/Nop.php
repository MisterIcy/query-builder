<?php

namespace MisterIcy\QueryBuilder\Operations;

final class Nop extends AbstractOperation
{
    public function __construct()
    {
        $this->forbiddenTypes = ['left' => [], 'right' =>[]];
        parent::__construct(null, null);
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return '';
    }
}