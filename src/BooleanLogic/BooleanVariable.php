<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 17:42
 */

namespace MBauer\BooleanLogic;


interface BooleanVariable extends NamedBooleanExpression
{
    public function isBound(): bool;
}