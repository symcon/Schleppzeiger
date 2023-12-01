<?php

declare(strict_types=1);

include_once __DIR__ . '/stubs/Validator.php';

class SchleppzeigerValidationTest extends TestCaseSymconValidation
{
    public function testValidateSymconDragPointer(): void
    {
        $this->validateLibrary(__DIR__ . '/..');
    }

    public function testValidateDragPointerModule(): void
    {
        $this->validateModule(__DIR__ . '/../DragPointer');
    }
}
