<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 16:44
 */

namespace MBauer\BooleanLogic;

interface MaterialConditional extends BooleanExpression
{
    public function getAntecedent(): ?BooleanExpression;
    public function getConsequent(): BooleanExpression;
}