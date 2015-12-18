<?php

use Expressly\Exception\ExceptionFormatter;
use Expressly\Exception\GenericException;

class ExceptionFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testGenericExceptionToString()
    {
        $exception = new GenericException('test message');
        $formatted = ExceptionFormatter::format($exception);

        $this->assertContains('Expressly\Exception\GenericException-test message', $formatted);
        $this->assertContains('ExceptionFormatterTest.php::10)', $formatted);
    }

    public function testOtherExceptionFormatted()
    {
        $exception = new Exception('not a defined exception');
        $formatted = ExceptionFormatter::format($exception);

        $this->assertContains('Exception-not a defined exception', $formatted);
        $this->assertContains('ExceptionFormatterTest.php::19)', $formatted);
    }
}