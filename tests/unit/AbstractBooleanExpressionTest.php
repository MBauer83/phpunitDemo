<?php

namespace MBauer\BooleanLogic\tests\unit;

use MBauer\BooleanLogic\AbstractBooleanExpression;
use MBauer\BooleanLogic\Biconditional;
use MBauer\BooleanLogic\Conjunction;
use MBauer\BooleanLogic\Disjunction;
use MBauer\BooleanLogic\MaterialConditional;
use MBauer\BooleanLogic\Negation;
use MBauer\BooleanLogic\PrimitiveBooleanValue;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;

class AbstractBooleanExpressionTest extends TestCase
{

    public function testImplies()
    {
        $mockInnervalue = $this->createMock(PrimitiveBooleanValue::class);
        $mockInnervalue->method('getValue')->willReturn(true);
        $mock = $this->createMock(AbstractBooleanExpression::class);
        $result = $mock->implies($mockInnervalue);
        $this->assertInstanceOf(MaterialConditional::class,$result);
    }

    public function testIsImpliedBy()
    {
        $mockInnervalue = $this->createMock(PrimitiveBooleanValue::class);
        $mockInnervalue->method('getValue')->willReturn(true);
        $mock = $this->createMock(AbstractBooleanExpression::class);
        $result = $mock->isImpliedBy($mockInnervalue);
        $this->assertInstanceOf(MaterialConditional::class,$result);
    }

    public function testNot()
    {
        $mockInnervalue = $this->createMock(PrimitiveBooleanValue::class);
        $mockInnervalue->method('getValue')->willReturn(true);
        $result = $mockInnervalue->not();
        $this->assertInstanceOf(Negation::class,$result);
    }


    public function testOr()
    {
        $mockInnervalue = $this->createMock(PrimitiveBooleanValue::class);
        $mockInnervalue->method('getValue')->willReturn(true);
        $mock = $this->createMock(AbstractBooleanExpression::class);
        $result = $mock->or($mockInnervalue);
        $this->assertInstanceOf(Disjunction::class,$result);
    }

    public function testAnd()
    {
        $mockInnervalue = $this->createMock(PrimitiveBooleanValue::class);
        $mockInnervalue->method('getValue')->willReturn(true);
        $mock = $this->createMock(AbstractBooleanExpression::class);
        $result = $mock->and($mockInnervalue);
        $this->assertInstanceOf(Conjunction::class,$result);
    }

    public function testBiconditional()
    {

    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }


}
