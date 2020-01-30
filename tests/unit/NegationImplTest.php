<?php

namespace MBauer\BooleanLogic\tests\unit;

use MBauer\BooleanLogic\NegationImpl;
use MBauer\BooleanLogic\PrimitiveBooleanValue;
use PHPUnit\Framework\TestCase;

class NegationImplTest extends TestCase
{
    protected PrimitiveBooleanValue $trueValFixture;
    protected PrimitiveBooleanValue $falseValFixture;

    public function setUp(): void
    {
        parent::setUp();
        $this->trueValFixture = new PrimitiveBooleanValue(true);
        $this->falseValFixture = new PrimitiveBooleanValue(false);
    }

    /**
     * Setting up fixtures to test for no exception thrown
     */
    public function testForSmoke()
    {

        try {
            $notTrue = new NegationImpl($this->trueValFixture);
        } catch (\Throwable $t) {
            $this->fail('Constructing NegationImpl with PrimitiveBooleanValue throws exception. Exception: ' . $t->getMessage());
            return;
        }
        $this->assertTrue(true);

    }


    public function testNegateTrueIsFalse()
    {
        $notTrue = new NegationImpl($this->trueValFixture);
        $this->assertFalse($notTrue->getValue());
    }


    public function testNegateFalseIsTrue()
    {
        $notFalse = new NegationImpl($this->falseValFixture);
        $this->assertTrue($notFalse->getValue());
    }

    public function testGetInnerValue()
    {

    }

}
