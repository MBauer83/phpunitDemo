<?php

namespace MBauer\BooleanLogic\tests\integration;

use MBauer\BooleanLogic\MaterialConditionalImpl;
use MBauer\BooleanLogic\PrimitiveBooleanValue;
use PHPUnit\Framework\TestCase;

class PrimitiveBooleanValueConjunctionTest extends TestCase
{
    public function testConjunctGetValueCallsInnerGetValues(): void
    {
        $innerMockA = $this->createMock(PrimitiveBooleanValue::class);
        $innerMockA->expects($this->once())->method('getValue');
        $innerMockB = $this->createMock(PrimitiveBooleanValue::class);
        $innerMockB->expects($this->once())->method('getValue');
        $cond = new MaterialConditionalImpl($innerMockA,$innerMockB);
        $cond->getValue();
    }
}
