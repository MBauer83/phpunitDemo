<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 03.04.2019
 * Time: 04:06
 */

namespace MBauer\BooleanLogic;


use Closure;
use InvalidArgumentException;
use ReflectionException;
use ReflectionFunction;
use ReflectionParameter;
use ReflectionType;
use stdClass;
use function count;

class ClosureBooleanVariable extends GenericBooleanVariable
{
    protected $closure;

    /**
     * ClosureBooleanVariable constructor.
     * @param string $name
     * @param Closure $closure
     * @throws ReflectionException
     * @throws InvalidArgumentException
     */
    public function __construct(string $name, Closure $closure)
    {
        parent::__construct($name);
        $refl = new ReflectionFunction($closure);
        $params = $refl->getParameters();
        /**
         * @var $returnType ReflectionType|null
         */
        $returnType = $refl->hasReturnType() ? $refl->getReturnType() : null;
        $has2Params = count($params) === 2;
        /**
         * @var $params ReflectionParameter[]
         * @var $reflType ReflectionType
         */
        $param1IsUntypedArrayStdClassOrDomain = !$has2Params ?
            false : (
                    !$params[0]->hasType()
                ||  $params[0]->isArray()
                ||  (
                            $reflType = $params[0]->getType()
                        &&  !$reflType->allowsNull()
                        &&  (
                                $reflType->getName() === stdClass::class
                            ||  $reflType->getName() === Domain::class
                        )
                )
            );
        $param2IsReferenceArray = !$has2Params ?
            false : (
                    $params[1]->isArray()
                &&  $params[1]->isPassedByReference()
            );
        $returnTypeIsBool = null !== $returnType && $returnType->getName() === 'bool';
        if (!$param1IsUntypedArrayStdClassOrDomain || !$param2IsReferenceArray || !$returnTypeIsBool) {
            throw new InvalidArgumentException('Closure must declare a boolean return type and accept exactly two arguments: context [array, stdClass or Domain] and errors [array by reference].');
        }
        $this->closure = $closure;
    }

    public function getValue(array &$errors,int $timoutSecs = 0): bool
    {
        /**
         * @var $closure Closure
         */
        $closure = $this->closure;
        return $closure($this->currentContext,$errors);
    }

}