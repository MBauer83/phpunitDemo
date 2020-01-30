<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 16:19
 */

namespace MBauer\BooleanLogic;


use InvalidArgumentException;
use ReflectionException;
use ReflectionProperty;
use stdClass;
use Throwable;
use function is_array;
use function is_object;

abstract class AbstractBooleanExpression implements BooleanExpression
{
    protected $value;
    protected $currentContext;
    protected $currentScope = 'static';

    protected function setValue(bool $value): void
    {
        $this->value = $value;
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function and(BooleanExpression $conjunctB): Conjunction
    {
        return new ConjunctionImpl($this,$conjunctB);
    }

    public function or(BooleanExpression $disjunctB): Disjunction
    {
        return new DisjunctionImpl($this,$disjunctB);
    }

    public function not(): Negation
    {
        return new NegationImpl($this);
    }

    public function implies(BooleanExpression $b): MaterialConditional
    {
        return new MaterialConditionalImpl($this,$b);
    }

    public function isImpliedBy(?BooleanExpression $a): MaterialConditional
    {
        return new MaterialConditionalImpl($a,$this);
    }

    public function biconditional(?BooleanExpression $b): Biconditional
    {
        return new BiconditionalImpl($this,$b);
    }

    /**
     * @param $context
     * @param string $name
     * @return bool
     */
    public static function contextHasValueForName($context, string $name): bool
    {
        $isArr = is_array($context);
        $isObj = is_object($context);
        if (!$isObj && !$isArr) {
            throw new InvalidArgumentException('Context [' . var_export($context,true) . '] must be array or object.');
        }
        $isDom = $isObj && ($context instanceof Domain);
        $isStdClass = $isObj && ($context instanceof stdClass);
        $val = null;
        if ($isArr || $isDom) {
            if (!array_key_exists($name,$context)) {
                return false;
            }
            $val = $context[$name];
        } elseif ($isObj) {
            if ($isDom) {
                /**
                 * @var $context Domain
                 */
                $val = $context->offsetExists($name) ? $context->offsetGet($name) : null;
            } elseif ($isStdClass) {
                try {
                    $val = $context->$name;
                } catch (Throwable $t) {
                    //Do nothing
                }
            }
        }
        if (is_object($val) && $val instanceof BooleanVariable) {
            $isBound = $val->isBound();
            return $isBound;
        }
        return null !== $val;
    }

    /**
     * @param string $key
     * @param $context
     * @return bool|mixed|null
     * @throws ReflectionException
     */
    public static function getValueFromContextForKey(string $key, $context)
    {
        $val = null;
        $isArr = is_array($context);
        $isObj = is_object($context);
        $isDom = $isObj && $context instanceof Domain;
        $isStdClass = $isObj && $context instanceof stdClass;
        if ($isArr) {
            $val = $context[$key] ?? null;
        } elseif ($isObj) {
            if ($isStdClass) {
                try {
                    $val = $context->$key;
                } catch (Throwable $t) {
                    //Do nothing
                }
            } elseif ($isDom) {
                /**
                 * @var $context Domain
                 */
                $val = $context->offsetExists($key) ? $context->offsetGet($key) : null;
            } else if (property_exists($context,$key)) {
                $reflProp = new ReflectionProperty($context,$key);
                $reflProp->setAccessible(true);
                $val = $reflProp->getValue();
            }
        }
        if ($isObj && $val instanceof NamedBooleanExpression) {
            $val->bindEvaluationContext($context);
            $val = $val->getValue();
        }
        return $val;
    }

    abstract public function bindEvaluationContext(&$newContext, $newScope = 'static'): void;

}