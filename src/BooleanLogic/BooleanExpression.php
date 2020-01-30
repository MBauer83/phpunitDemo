<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 15:54
 */

namespace MBauer\BooleanLogic;


interface BooleanExpression
{
    public function getValue(): bool;
    public function and(BooleanExpression $conjunctB): Conjunction;
    public function or(BooleanExpression $disjunctB): Disjunction;
    public function not(): Negation;
    public function implies(BooleanExpression $b): MaterialConditional;
    public function isImpliedBy(?BooleanExpression $a): MaterialConditional;
    public function biconditional(?BooleanExpression $b): Biconditional;
    public function bindEvaluationContext(&$newContext,$newScope = 'static'): void;
}