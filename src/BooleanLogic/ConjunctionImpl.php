<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 16:02
 */

namespace MBauer\BooleanLogic;


class ConjunctionImpl extends AbstractBooleanExpression implements Conjunction
{
    protected $conjunctA;
    protected $conjunctB;

    public function __construct(BooleanExpression $a, BooleanExpression$b)
    {
        $this->conjunctA = $a;
        $this->conjunctB = $b;
    }

    public static function createConjunction(BooleanExpression $a, BooleanExpression $b): Conjunction
    {
        return new self($a,$b);
    }

    public function getValue(array &$errors): bool
    {
        return $this->conjunctA->getValue($errors) && $this->conjunctB->getValue($errors);
    }

    public function getConjunctA(): BooleanExpression
    {
        return $this->conjunctA;
    }

    public function getConjunctB(): BooleanExpression
    {
        return $this->conjunctB;
    }

    public function isBound(): bool
    {
        return (!($this->conjunctA instanceof BooleanVariable) || $this->conjunctA->isBound()) && (!($this->conjunctB instanceof BooleanVariable) || $this->conjunctB->isBound());
    }

    public function bindEvaluationContext(&$newContext, $newScope = 'static'): void
    {
        $this->conjunctA->bindEvaluationContext($newContext,$newScope);
        $this->conjunctB->bindEvaluationContext($newContext,$newScope);
    }


}