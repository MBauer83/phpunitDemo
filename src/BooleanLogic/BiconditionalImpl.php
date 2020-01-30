<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 17:23
 */

namespace MBauer\BooleanLogic;


class BiconditionalImpl extends AbstractBooleanExpression implements Biconditional
{
    /**
     * @var null|BooleanExpression
     */
    protected $leftValue;
    /**
     * @var null|BooleanExpression
     */
    protected $rightValue;

    /**
     * BiconditionalImpl constructor.
     * @param BooleanExpression|null $leftValue
     * @param BooleanExpression|null $rightValue
     */
    public function __construct(?BooleanExpression $leftValue, ?BooleanExpression $rightValue)
    {
        $this->leftValue = $leftValue;
        $this->rightValue = $rightValue;
    }

    /**
     * @return BooleanExpression|null
     */
    public function getLeftValue(): ?BooleanExpression
    {
        return $this->leftValue;
    }

    /**
     * @return BooleanExpression|null
     */
    public function getRightValue(): ?BooleanExpression
    {
        return $this->rightValue;
    }

    public function isBound(): bool
    {
        return (!($this->leftValue instanceof BooleanVariable) || $this->leftValue->isBound()) && ((!$this->rightValue instanceof BooleanVariable) || $this->rightValue->isBound());
    }

    public function getValue(): bool
    {
        $aVal = null === $this->leftValue ? false : $this->leftValue->getValue();
        $bVal = null === $this->rightValue ? false : $this->rightValue->getValue();
        return $aVal === $bVal;
    }


    public function bindEvaluationContext(&$newContext,$newScope = 'static'): void
    {
        if (null !== $this->leftValue) {
            $this->leftValue->bindEvaluationContext($newContext,$newScope);
        }
        if (null !== $this->rightValue) {
            $this->rightValue->bindEvaluationContext($newContext,$newScope);
        }
    }


}