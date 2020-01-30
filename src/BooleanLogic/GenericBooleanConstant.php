<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 19:38
 */

namespace MBauer\BooleanLogic;


class GenericBooleanConstant extends AbstractBooleanExpression implements BooleanConstant
{
    protected $name;

    /**
     * GenericBooleanConstant constructor.
     * @param string $name
     * @param bool $value
     */
    public function __construct(string $name, bool $value)
    {
        $this->name = $name;
        $this->value = $value;
    }


    public function isBound(): bool
    {
        //Constants are treated as bound variabled
        return true;
    }

    public static function fromNameAndValue(string $name, bool $value): BooleanConstant
    {
        return new self($name,$value);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function bindEvaluationContext(&$newContext, $newScope = 'static'): void
    {
        $this->currentContext = $newContext;
        $this->currentScope = $newScope;
    }


}