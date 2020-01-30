<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 15:58
 */

namespace MBauer\BooleanLogic;


interface Conjunction extends BooleanExpression
{
    public function getConjunctA(): BooleanExpression;
    public function getConjunctB(): BooleanExpression;
}