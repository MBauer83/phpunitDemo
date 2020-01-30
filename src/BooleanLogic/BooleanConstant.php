<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 18:04
 */

namespace MBauer\BooleanLogic;


interface BooleanConstant extends NamedBooleanExpression
{
    public static function fromNameAndValue(string $name, bool $value): self;
}