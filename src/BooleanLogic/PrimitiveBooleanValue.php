<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 16:01
 */

namespace MBauer\BooleanLogic;


class PrimitiveBooleanValue extends AbstractBooleanExpression implements BooleanExpression
{

    public function __construct(bool $value)
    {
        $this->setValue($value);
    }

    public function bindEvaluationContext(&$newContext, $newScope = 'static'): void
    {
        $this->currentContext = $newContext;
        $this->currentScope = $newScope;
    }


}