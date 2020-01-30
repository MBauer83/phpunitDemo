<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 15:56
 */

namespace MBauer\BooleanLogic;


interface Negation extends BooleanExpression
{
    public static function createNegation(BooleanExpression $valueToNegate): self;
    public function getInnerValue(): BooleanExpression;
}