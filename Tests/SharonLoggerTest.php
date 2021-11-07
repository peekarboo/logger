<?php


use Ampersandhq\ChallengeLogger\SharonLogger;
use PHPUnit\Framework\TestCase;

class SharonLoggerTest extends TestCase
{
    private $logFile;
    private $loggerTest;

    public function setUp()
    {
        $this->logFile = 'LogUnitTest.log';
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }
        $this->loggerTest = new SharonLogger($this->logFile);
    }


    public function tearDown()
    {
        if (file_exists($this->loggerTest->getDirectory() . $this->logFile)) {
            unlink($this->loggerTest->getDirectory() . $this->logFile);
        }
    }


    public function testGetTime(): void
    {
        $this->assertRegExp('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2} [a-z]{2}$/', $this->loggerTest->getTime());
    }

    /**
     * @testCase  Test to check if the temp file exists
     */
    public function testLogFile(): void
    {
        $this->loggerTest->info("Testing log file exists");
        $this->assertTrue(file_exists($this->loggerTest->getDirectory() . $this->logFile));
    }

    /**
     * @testCase  Test to check correct input is logged
     */
    public function testInputs(): void
    {
        $this->loggerTest->error("Testing if it records correct log level");
        $log_line = trim(file_get_contents($this->loggerTest->getDirectory() . $this->logFile));
        $this->assertTrue((bool)preg_match(' /Testing if it records correct log level/ ', $log_line));
        $this->assertTrue((bool)preg_match(' /error/ ', $log_line));
    }

    /**
     * @testCase Log lines will be on a single line even if there are newline characters in the log message.
     */
    public function testLogMessageIsOneLine()
    {
        $this->loggerTest->info("creating messages with more than one new lines \n,second line\n");
        $this->loggerTest->info("creating messages with more than one new lines \n,second line\n");
        $this->loggerTest->info("creating messages with more than one new lines \n,second line\n");
        $log_lines = file($this->loggerTest->getDirectory() . $this->logFile);
        $this->assertEquals(3, count($log_lines));
    }

    /**
     * @testCase Throws an Exception if the log file cannot be opened.
     */
    public function testExceptionCannotOpenFile()
    {
        $badDirectory = new SharonLogger('/wrong/directory/.log.log');
        $this->expectException(\RuntimeException::class);
        $badDirectory->info('This is not going to work, hence the test for the exception!');
    }

}
