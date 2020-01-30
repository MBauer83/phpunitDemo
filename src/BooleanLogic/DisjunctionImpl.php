<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 16:04
 */

namespace MBauer\BooleanLogic;


class DisjunctionImpl extends AbstractBooleanExpression implements Disjunction
{
    protected $disjunctA;
    protected $disjunctB;

    public function __construct(BooleanExpression $a, BooleanExpression $b)
    {
        $this->disjunctA = $a;
        $this->disjunctB = $b;
    }

    public static function createDisjunction(BooleanExpression $a, BooleanExpression $b): Disjunction
    {
        return new self($a,$b);
    }

    public function getValue(array &$errors): bool
    {
        return $this->disjunctA->getValue($errors) || $this->disjunctB->getValue($errors);
    }


    /**
     * @return BooleanExpression
     */
    public function getDisjunctA(): BooleanExpression
    {
        return $this->disjunctA;
    }

    /**
     * @return BooleanExpression
     */
    public function getDisjunctB(): BooleanExpression
    {
        return $this->disjunctB;
    }

    public function isBound(): bool
    {
        return (!($this->disjunctA instanceof BooleanVariable) || $this->disjunctA->isBound()) && (!($this->disjunctB instanceof BooleanVariable) || $this->disjunctB->isBound());
    }

    public function bindEvaluationContext(&$newContext, $newScope = 'static'): void
    {
        $this->disjunctA->bindEvaluationContext($newContext,$newScope);
        $this->disjunctB->bindEvaluationContext($newContext,$newScope);
    }

}