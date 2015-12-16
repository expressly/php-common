<?php

use Expressly\Validator\UuidValidator;

class UuidValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new UuidValidator('uuid');
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf('Expressly\Validator\ValidatorInterface', $this->validator);
    }

    public function testType()
    {
        $this->assertEquals('uuid_string', UuidValidator::getType());
    }

    public function testValidUuid()
    {
        $this->assertTrue($this->validator->validate('37dffda3-b2a7-44de-abce-44eb48a84af3'));
    }

    public function testInvalidUuid()
    {
        $this->assertFalse($this->validator->validate('38192283139981'));
    }

    public function testInvalidInput()
    {
        $this->assertFalse($this->validator->validate(array()));
    }

    public function testMessage()
    {
        $this->assertEquals('uuid', $this->validator->getMessage());
    }
}