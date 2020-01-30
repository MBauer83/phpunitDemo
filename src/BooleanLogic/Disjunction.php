<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 15:59
 */

namespace MBauer\BooleanLogic;


interface Disjunction extends BooleanExpression
{
    public static function createDisjunction(BooleanExpression $a, BooleanExpression $b): self;
    public function getDisjunctA(): BooleanExpression;
    public function getDisjunctB(): BooleanExpression;
}