<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Micha
 * Date: 02.04.2019
 * Time: 20:34
 */

use MBauer\BooleanLogic\BiconditionalImpl;
use MBauer\BooleanLogic\GenericBooleanConstant;
use MBauer\BooleanLogic\GenericBooleanVariable;
use MBauer\BooleanLogic\MaterialConditionalImpl;

include(__DIR__ . '../../vendor/autoload.php');

$constA = new GenericBooleanConstant('A',true);
$constB = new GenericBooleanConstant('B',false);
$varX = new GenericBooleanVariable('X');
$contextTrue = [
    'X' => true,
];
$contextFalse = [
    'X' => false,
];

$constantNegationOfTrue = $constA->not();
$constantNegationOfFalse = $constB->not();
$varNegation = $varX->not();

$constantConjunctTrueFalse = $constA->and($constB);
$constantConjunctTrueTrue = $constA->and($constA);
$constantConjunctFalseTrue = $constB->and($constA);
$constantConjunctFalseFalse = $constB->and($constB);
$varConjunctLeftRightTrue = $varX->and($constA);
$varConjunctLeftRightFalse = $varX->and($constB);
$varConjunctRightLeftTrue = $constA->and($varX);
$varConjunctRightLeftFalse = $constB->and($varX);

$constantDisjunctFalseFalse = $constB->or($constB);
$constantDisjunctTrueFalse = $constA->or($constB);
$constantDisjunctFalseTrue = $constB->or($constA);
$constantDisjunctTrueTrue = $constA->or($constA);
$varDisjunctLeftRightTrue = $varX->or($constA);
$varDisjunctLeftRightFalse = $varX->or($constB);
$varDisjunctRightLeftTrue = $constA->or($varX);
$varDisjunctRightLeftFalse = $constB->or($varX);

$constantImplicationEmptyTrue = new MaterialConditionalImpl(null,$constA);
$constantImplicationEmptyFalse = new MaterialConditionalImpl(null,$constB);
$constantImplicationTrueTrue = new MaterialConditionalImpl($constA,$constA);
$constantImplicationTrueFalse = new MaterialConditionalImpl($constA,$constB);
$constantImplicationFalseTrue = new MaterialConditionalImpl($constB,$constA);
$constantImplicationFalseFalse = new MaterialConditionalImpl($constB,$constB);
$varImplicationEmpty = new MaterialConditionalImpl(null,$varX);
$varImplicationTrue = new MaterialConditionalImpl($varX,$constA);
$varImplicationFalse = new MaterialConditionalImpl($varX,$constB);
$varImplicationRightLeftTrue = new MaterialConditionalImpl($constA,$varX);
$varImplicationRightLeftFalse = new MaterialConditionalImpl($constB,$varX);

$constBiconEmptyEmpty = new BiconditionalImpl(null,null);
$constBiconEmptyFalse = new BiconditionalImpl(null,$constB);
$constBiconEmptyTrue = new BiconditionalImpl(null,$constA);
$constBiconFalseEmpty = new BiconditionalImpl($constB,null);
$constBiconTrueEmpty = new BiconditionalImpl($constA,null);
$constBiconTrueTrue = new BiconditionalImpl($constA,$constA);
$constBiconTrueFalse = new BiconditionalImpl($constA,$constB);
$constBiconFalseTrue = new BiconditionalImpl($constB,$constA);
$constBiconFalseFalse = new BiconditionalImpl($constB,$constB);
$varBiconLeftEmpty = new BiconditionalImpl($varX,null);
$varBiconRightEmpty = new BiconditionalImpl(null,$varX);
$varBiconLeftFalse = new BiconditionalImpl($varX,$constB);
$varBiconLeftTrue = new BiconditionalImpl($varX,$constA);
$varBiconRightFalse = new BiconditionalImpl($constB,$varX);
$varBiconRightTrue = new BiconditionalImpl($constA,$varX);

//constant Tests
$errors = [];
assert($constantNegationOfFalse->getValue($errors) === true,'Negation of false must be true.');
assert($constantNegationOfTrue->getValue($errors) === false, 'Negation of true must be false.');

assert($constantConjunctFalseFalse->getValue($errors) === false, 'Conjunction of false and false must be false.');
assert($constantConjunctFalseTrue->getValue($errors) === false, 'Conjunction of false and true must be false.');
assert($constantConjunctTrueFalse->getValue($errors) === false,'Conjunction of true and false must be false.');
assert($constantConjunctTrueTrue->getValue($errors) === true, 'Conjunction of true and true must be true.');

assert($constantDisjunctFalseFalse->getValue($errors) === false, 'Disjunction of false and false must be false.');
assert($constantDisjunctFalseTrue->getValue($errors) === true, 'Disjunction of false and true must be true.');
assert($constantDisjunctTrueFalse->getValue($errors) === true, 'Disjunction of true and false must be true.');
assert($constantDisjunctTrueTrue->getValue($errors) === true, 'Disjunction of true and true must be true.');

assert($constantImplicationEmptyFalse->getValue($errors) === true,'Material Conditional of empty and false must be true.');
assert($constantImplicationEmptyTrue->getValue($errors) === true,'Material Conditional of empty and true must be true.');
assert($constantImplicationTrueFalse->getValue($errors) === false,'Material Conditional of true and false must be false.');
assert($constantImplicationTrueTrue->getValue($errors) === true,'Material Conditional of true and true must be true.');
assert($constantImplicationFalseFalse->getValue($errors) === true,'Material Conditional of false and false must be true.');

assert($constBiconEmptyEmpty->getValue($errors) === true,'Biconditional of empty and empty must be true.');
assert($constBiconEmptyFalse->getValue($errors) === true,'Biconditional of empty and false must be true.');
assert($constBiconEmptyTrue->getValue($errors) === false,'Biconditional of empty and true must be false.');
assert($constBiconTrueEmpty->getValue($errors) === false,'Biconditional of true and empty must be false.');
assert($constBiconTrueTrue->getValue($errors) === true,'Biconditional of true and true must be true.');
assert($constBiconTrueFalse->getValue($errors) === false,'Biconditional of true and false must be false.');
assert($constBiconFalseEmpty->getValue($errors) === true,'Biconditional of false and empty must be true.');
assert($constBiconFalseTrue->getValue($errors) === false,'Biconditional of false and true must be false.');
assert($constBiconFalseFalse->getValue($errors) === true,'Biconditional of false and false must be true.');

//variable tests
//  - if true
$context = &$contextTrue;
$varNegation->bindEvaluationContext($context);
assert($varNegation->getValue($errors) === false, 'Negation on true variable must evaluate to false.');

$varConjunctLeftRightFalse->bindEvaluationContext($context);
$varConjunctLeftRightTrue->bindEvaluationContext($context);
$varConjunctRightLeftFalse->bindEvaluationContext($context);
$varConjunctRightLeftTrue->bindEvaluationContext($context);
assert($varConjunctLeftRightFalse->getValue($errors) === false, 'Conjunct of true variable with false must be false.');
assert($varConjunctLeftRightTrue->getValue($errors) === true, 'Conjunct of true variable with true must be true.');
assert($varConjunctRightLeftFalse->getValue($errors) === false,'Conjunct of false with true variable must be false.');
assert($varConjunctRightLeftTrue->getValue($errors) === true,'Conjunct of true with true variable must be true.');

$varDisjunctLeftRightFalse->bindEvaluationContext($context);
$varDisjunctLeftRightTrue->bindEvaluationContext($context);
$varDisjunctRightLeftFalse->bindEvaluationContext($context);
$varDisjunctRightLeftTrue->bindEvaluationContext($context);
assert($varDisjunctLeftRightFalse->getValue($errors) === true, 'Disjunct of true variable with false must be true.');
assert($varDisjunctLeftRightTrue->getValue($errors) === true, 'Disjunct of true variable with true must be true.');
assert($varDisjunctRightLeftFalse->getValue($errors) === true,'Disjunct of false with true variable must be true.');
assert($varDisjunctRightLeftTrue->getValue($errors) === true,'Disjunct of true with true variable must be true.');

$varImplicationEmpty->bindEvaluationContext($context);
$varImplicationFalse->bindEvaluationContext($context);
$varImplicationTrue->bindEvaluationContext($context);
$varImplicationRightLeftFalse->bindEvaluationContext($context);
$varImplicationRightLeftTrue->bindEvaluationContext($context);
assert($varImplicationEmpty->getValue($errors) === true, 'Implication from empty to true variable must be true.');
assert($varImplicationFalse->getValue($errors) === false,'Implication from true variable to false must be false.');
assert($varImplicationTrue->getValue($errors) === true,'Implication from true variable to true must be true.');
assert($varImplicationRightLeftTrue->getValue($errors) === true, 'Implication from true to true variable must be true.');
assert($varImplicationRightLeftFalse->getValue($errors) === true, 'Implication from false to true variable must be true.');

$varBiconLeftEmpty->bindEvaluationContext($context);
$varBiconLeftFalse->bindEvaluationContext($context);
$varBiconLeftTrue->bindEvaluationContext($context);
$varBiconRightEmpty->bindEvaluationContext($context);
$varBiconRightFalse->bindEvaluationContext($context);
$varBiconRightTrue->bindEvaluationContext($context);
assert($varBiconLeftEmpty->getValue($errors) === false,'Biconditional with true variable end empty must be false.');
assert($varBiconLeftFalse->getValue($errors) === false,'Biconditional with true variable end false must be false.');
assert($varBiconLeftTrue->getValue($errors) === true,'Biconditional with true variable end true must be true.');
assert($varBiconRightEmpty->getValue($errors) === false,'Biconditional with empty and true variable must be false.');
assert($varBiconRightFalse->getValue($errors) === false,'Biconditional with false and true variable must be false.');
assert($varBiconRightTrue->getValue($errors) === true,'Biconditional with true and true variable must be true.');

// - if false
$context = &$contextFalse;
$varNegation->bindEvaluationContext($context);
assert($varNegation->getValue($errors) === true, 'Negation on false variable must evaluate to true.');

$varConjunctLeftRightFalse->bindEvaluationContext($context);
$varConjunctLeftRightTrue->bindEvaluationContext($context);
$varConjunctRightLeftFalse->bindEvaluationContext($context);
$varConjunctRightLeftTrue->bindEvaluationContext($context);
assert($varConjunctLeftRightFalse->getValue($errors) === false, 'Conjunct of false variable with false must be false.');
assert($varConjunctLeftRightTrue->getValue($errors) === false, 'Conjunct of false variable with true must be false.');
assert($varConjunctRightLeftFalse->getValue($errors) === false,'Conjunct of false with false variable must be false.');
assert($varConjunctRightLeftTrue->getValue($errors) === false,'Conjunct of true with false variable must be false.');

$varDisjunctLeftRightFalse->bindEvaluationContext($context);
$varDisjunctLeftRightTrue->bindEvaluationContext($context);
$varDisjunctRightLeftFalse->bindEvaluationContext($context);
$varDisjunctRightLeftTrue->bindEvaluationContext($context);
assert($varDisjunctLeftRightFalse->getValue($errors) === false, 'Disjunct of false variable with false must be false.');
assert($varDisjunctLeftRightTrue->getValue($errors) === true, 'Disjunct of false variable with true must be true.');
assert($varDisjunctRightLeftFalse->getValue($errors) === false,'Disjunct of false with false variable must be false.');
assert($varDisjunctRightLeftTrue->getValue($errors) === true,'Disjunct of true with false variable must be true.');

$varImplicationEmpty->bindEvaluationContext($context);
$varImplicationFalse->bindEvaluationContext($context);
$varImplicationTrue->bindEvaluationContext($context);
$varImplicationRightLeftFalse->bindEvaluationContext($context);
$varImplicationRightLeftTrue->bindEvaluationContext($context);
assert($varImplicationEmpty->getValue($errors) === true, 'Implication from empty to false variable must be true.');
assert($varImplicationFalse->getValue($errors) === true,'Implication from false variable to false must be true.');
assert($varImplicationTrue->getValue($errors) === true,'Implication from false variable to true must be true.');
assert($varImplicationRightLeftTrue->getValue($errors) === false, 'Implication from true to false variable must be false.');
assert($varImplicationRightLeftFalse->getValue($errors) === true, 'Implication from false to false variable must be true.');

$varBiconLeftEmpty->bindEvaluationContext($context);
$varBiconLeftFalse->bindEvaluationContext($context);
$varBiconLeftTrue->bindEvaluationContext($context);
$varBiconRightEmpty->bindEvaluationContext($context);
$varBiconRightFalse->bindEvaluationContext($context);
$varBiconRightTrue->bindEvaluationContext($context);
assert($varBiconLeftEmpty->getValue($errors) === true,'Biconditional with false variable and empty must be true.');
assert($varBiconLeftFalse->getValue($errors) === true,'Biconditional with false variable and false must be true.');
assert($varBiconLeftTrue->getValue($errors) === false,'Biconditional with false variable and true must be false.');
assert($varBiconRightEmpty->getValue($errors) === true,'Biconditional with empty and false variable must be true.');
assert($varBiconRightFalse->getValue($errors) === true,'Biconditional with false and false variable must be true.');
assert($varBiconRightTrue->getValue($errors) === false,'Biconditional with true and false variable must be false.');

echo "All assertions executed." . PHP_EOL;