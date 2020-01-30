<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 19:49
 */

namespace MBauer\BooleanLogic;


use ReflectionException;
use RuntimeException;
use Throwable;

class GenericBooleanVariable extends AbstractBooleanExpression implements BooleanVariable
{
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param array $errors
     * @param int $timeoutSec
     * @return bool
     * @throws ReflectionException
     * @throws Throwable
     */
    public function getValue(array &$errors,int $timeoutSec = 0): bool
    {
        if (!$this->isBound()) {
            throw new RuntimeException('Variable [' . $this->getName() . '] is not bound at runtime.');
        }
        $val = self::getValueFromContextForKey($this->getName(),$this->currentContext,$timeoutSec);
        return $val;
    }

    /**
     * @return bool
     * @throws ReflectionException
     */
    public function isBound(): bool
    {
        return self::contextHasValueForName($this->currentContext, $this->getName());
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