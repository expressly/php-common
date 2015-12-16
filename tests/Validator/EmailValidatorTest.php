<?php

use Expressly\Validator\EmailValidator;

class EmailValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new EmailValidator('email');
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf('Expressly\Validator\ValidatorInterface', $this->validator);
    }

    public function testType()
    {
        $this->assertEquals('email', EmailValidator::getType());
    }

    public function testValidUuid()
    {
        $this->assertTrue($this->validator->validate('test@test.com'));
        $this->assertTrue($this->validator->validate('test@test.co.uk'));
        $this->assertTrue($this->validator->validate('test@sub.test.co.uk'));
        $this->assertTrue($this->validator->validate('first.last@test.com'));
    }

    public function testInvalidUuid()
    {
        $this->assertFalse($this->validator->validate('test.com'));
        $this->assertFalse($this->validator->validate('test@.com'));
        $this->assertFalse($this->validator->validate('@.com'));
        $this->assertFalse($this->validator->validate('@ok.com'));
        $this->assertFalse($this->validator->validate('a@ok'));
    }

    public function testInvalidInput()
    {
        $this->assertFalse($this->validator->validate(array()));
    }

    public function testMessage()
    {
        $this->assertEquals('email', $this->validator->getMessage());
    }
}