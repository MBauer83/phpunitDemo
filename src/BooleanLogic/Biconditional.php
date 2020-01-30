<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 16:53
 */

namespace MBauer\BooleanLogic;

interface Biconditional
{
    public function getLeftValue(): ?BooleanExpression;
    public function getRightValue(): ?BooleanExpression;
}