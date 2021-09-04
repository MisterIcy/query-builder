<?php

namespace MisterIcy\QueryBuilder\Operations;

use MisterIcy\QueryBuilder\Exceptions\NullArgumentException;

final class In extends AbstractOperation
{
    /**
     * @param string $field
     * @param array<string|int|float> $terms
     */
    public function __construct(string $field, array $terms)
    {
        $this->forbiddenTypes = [
            'left' => ['object', 'array', 'null'],
            'right' => ['null', 'object']
        ];
        if (count($terms) == 0) {
            throw new NullArgumentException();
        }
        parent::__construct($field, $terms);
        $this->operator = 'IN';
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        if (is_array($this->rightOperand)) {
            $this->rightOperand = implode(',', $this->rightOperand);
        }
        return sprintf("%s %s (%s)", $this->leftOperand, $this->operator, $this->rightOperand);
    }
}
