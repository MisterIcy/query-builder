<?php

namespace MisterIcy\QueryBuilder\Operations;

use MisterIcy\QueryBuilder\Exceptions\InvalidArgumentException;
use MisterIcy\QueryBuilder\Exceptions\NullArgumentException;
use MisterIcy\QueryBuilder\Expressions\AbstractExpression;
use ReflectionException;
use ReflectionFunction;

abstract class AbstractOperation extends AbstractExpression
{
    /**
     * @var mixed
     */
    protected $leftOperand;
    /**
     * @var mixed
     */
    protected $rightOperand;
    protected string $operator;

    /**
     * @var string[][]
     */
    protected array $forbiddenTypes = [
        'left' => ['null', 'object', 'array'],
        'right' => ['null', 'object', 'array']
    ];

    /**
     * @param mixed $leftOperand
     * @param mixed $rightOperand
     */
    public function __construct($leftOperand, $rightOperand)
    {
        parent::__construct(0);
        $this->leftOperand = $leftOperand;
        $this->rightOperand = $rightOperand;
        $this->checkOperandTypes();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return sprintf('%s %s %s', strval($this->leftOperand), $this->operator, strval($this->rightOperand));
    }

    private function checkOperandTypes(): void
    {
        if (array_key_exists('left', $this->forbiddenTypes)) {
            $this->checkOperand($this->leftOperand, $this->forbiddenTypes['left']);
        }
        if (array_key_exists('right', $this->forbiddenTypes)) {
            $this->checkOperand($this->rightOperand, $this->forbiddenTypes['right']);
        }
    }

    /**
     * @param mixed $operand
     * @param string[] $types
     * @throws InvalidArgumentException
     * @throws ReflectionException
     */
    private function checkOperand($operand, $types): void
    {
        foreach ($types as $type) {
            $function = new ReflectionFunction('is_' . $type);
            if ($function->invoke($operand) === true) {
                throw new InvalidArgumentException();
            }
        }
    }
}
