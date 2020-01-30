<?php

namespace MBauer\BooleanLogic\tests\integration;

use MBauer\BooleanLogic\NegationImpl;
use MBauer\BooleanLogic\PrimitiveBooleanValue;
use PHPUnit\Framework\TestCase;

class PrimitiveBooleanValueNegationTest extends TestCase
{

    public function testNegateCallsGetValueOnInner(): void
    {
        $innerMock = $this->createMock(PrimitiveBooleanValue::class);
        $innerMock->expects($this->once())->method('getValue');
        $neg = new NegationImpl($innerMock);
        $neg->getValue();
    }

}
