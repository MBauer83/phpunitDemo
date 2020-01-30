<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 16:09
 */

namespace MBauer\BooleanLogic;


class NegationImpl extends AbstractBooleanExpression implements Negation
{
    protected $innerValue;

    public function __construct(BooleanExpression $innerValue)
    {
        $this->innerValue = $innerValue;
    }

    public function getValue(): bool
    {
        return !$this->innerValue->getValue();
    }


    public static function createNegation(BooleanExpression $valueToNegate): Negation
    {
        return new self($valueToNegate);
    }

    public function getInnerValue(): BooleanExpression
    {
        return $this->innerValue;
    }

    public function isBound(): bool
    {
        return (!($this->innerValue instanceof BooleanVariable) || $this->innerValue->isBound());
    }

    public function bindEvaluationContext(&$newContext, $newScope = 'static'): void
    {
        $this->innerValue->bindEvaluationContext($newContext,$newScope);
    }


}