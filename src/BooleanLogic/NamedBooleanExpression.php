<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 18:41
 */

namespace MBauer\BooleanLogic;


interface NamedBooleanExpression extends BooleanExpression
{
    public function getName(): string;
}