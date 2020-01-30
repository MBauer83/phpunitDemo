<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 17:15
 */

namespace MBauer\BooleanLogic;


class MaterialConditionalImpl extends AbstractBooleanExpression implements MaterialConditional
{
    /**
     * @var BooleanExpression|null
     */
    protected $antecedent;
    /**
     * @var BooleanExpression
     */
    protected $consequent;

    /**
     * MaterialConditionalImpl constructor.
     * @param BooleanExpression|null $antecedent
     * @param BooleanExpression $consequent
     */
    public function __construct(?BooleanExpression $antecedent, BooleanExpression $consequent)
    {
        $this->antecedent = $antecedent;
        $this->consequent = $consequent;
    }

    public function getValue(): bool
    {
        $antVal = null;
        if (null !== $this->antecedent) {
            $antVal = $this->antecedent->getValue();
        }
        $conVal = $this->consequent->getValue();
        $retVal = !($antVal === true && $conVal === false);
        return $retVal;
    }

    /**
     * @return BooleanExpression|null
     */
    public function getAntecedent(): ?BooleanExpression
    {
        return $this->antecedent;
    }

    /**
     * @return BooleanExpression
     */
    public function getConsequent(): BooleanExpression
    {
        return $this->consequent;
    }

    public function isBound(): bool
    {
        return (!($this->antecedent instanceof BooleanVariable) || $this->antecedent->isBound()) && (!($this->consequent instanceof BooleanVariable) || $this->consequent->isBound());
    }

    public function bindEvaluationContext(&$newContext, $newScope = 'static'): void
    {
        if (null !== $this->antecedent) {
            $this->antecedent->bindEvaluationContext($newContext,$newScope);
        }
        $this->consequent->bindEvaluationContext($newContext,$newScope);
    }


}