<?php

namespace MisterIcy\QueryBuilder\Operations;

final class Between extends AbstractOperation
{
    private string $field;

    /**
     * @param mixed $leftOperand
     * @param mixed $rightOperand
     */
    public function __construct(string $field, $leftOperand, $rightOperand)
    {
        parent::__construct($leftOperand, $rightOperand);
        $this->operator = 'BETWEEN';
        $this->field = $field;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s %s %s AND %s',
            $this->field,
            $this->operator,
            $this->leftOperand,
            $this->rightOperand
        );
    }
}