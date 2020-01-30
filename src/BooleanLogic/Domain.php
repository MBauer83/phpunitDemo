<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 18:35
 */

namespace MBauer\BooleanLogic;


use ArrayAccess;
use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use OutOfBoundsException;
use function array_key_exists;
use function is_object;

class Domain implements ArrayAccess, IteratorAggregate
{
    protected $elements;
    protected $variableNames = [];
    protected $contextValues = [];

    protected function add(NamedBooleanExpression $namedBooleanValue): void
    {
        $name = $namedBooleanValue->getName();
        $this->elements[$name] = $namedBooleanValue;
        if ($namedBooleanValue instanceof BooleanVariable) {
            $namedBooleanValue->bindEvaluationContext($this,$this);
            $this->variableNames[$name] = $name;
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset,$this->elements);
    }

    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    public function offsetSet($offset, $value)
    {
        if (!is_object($value) || !($value instanceof NamedBooleanExpression)) {
            throw new InvalidArgumentException('Can only set valued of type NamedBooleanExpression.');
        }
        if ($value->getName() !== $offset) {
            throw new InvalidArgumentException('Offset must be the name of the NamedBooleanExpression.');
        }
        $this->add($value);
    }

    public function offsetUnset($offset)
    {
        if (array_key_exists($offset,$this->elements)) {
            unset($this->elements[$offset]);
            if (array_key_exists($offset,$this->variableNames)) {
                unset($this->variableNames[$offset]);
            }
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name,$this->contextValues)) {
            $val = $this->contextValues[$name];
            if (is_object($val) && $val instanceof BooleanExpression) {
                $dummy = [];
                return $val->getValue($dummy);
            }
        }

        if (array_key_exists($name,$this->elements)) {
            $el = $this->elements[$name];
            /**
             * @var $el NamedBooleanExpression
             */
            $dummy = [];
            return $el->getValue($dummy);
        }
        throw new OutOfBoundsException('Offset [' . $name . '] does not exist.');
    }

    public function setContextValue(string $name, $value)
    {
        $this->contextValues[$name] = $value;
    }

}