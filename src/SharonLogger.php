<?php

namespace Ampersandhq\ChallengeLogger;

use Psr\Log\LogLevel;

class SharonLogger
{
    private string $logFile;

    public function __construct(string $logFile = "logfile.log")
    {
        $this->logFile = $logFile;
    }

    /**
     * Get current date time.
     * Format: YYYY-mm-dd HH:ii:ss.am/pm
     * @return string Date time
     */
    public function getTime(): string
    {
        return (new \DateTimeImmutable('now'))->format('Y-m-d H:i:s a');
    }

    /**
     * Open files and write log to file
     */
    private function log($loglevel, string $message): void
    {
        $logLine = $this->logLine($loglevel, $message);
        $logFileName = $this->CreateDirectory() . $this->logFile;


        // Log to file
        try {
            $file = fopen($logFileName, 'a');
            fwrite($file, $logLine);
            fclose($file);
        } catch (\Throwable $e) {
            throw new \RuntimeException("Could not open log file $this->logFile ", 0, $e);
        }
    }

    /**
     * @param string $message
     */
    public function emergency(string $message = ''): void
    {
        $this->log(LogLevel::EMERGENCY, $message);
    }

    /**
     * @param string $message
     */
    public function alert(string $message = ''): void
    {
        $this->log(LogLevel::ALERT, $message);
    }

    /**
     * @param string $message
     */
    public function critical(string $message = ''): void
    {
        $this->log(LogLevel::CRITICAL, $message);
    }

    /**
     * @param string $message
     */
    public function debug(string $message = ''): void
    {
        $this->log(LogLevel::DEBUG, $message);
    }

    /**
     * @param string $message
     */
    public function error(string $message = ''): void
    {
        $this->log(LogLevel::ERROR, $message);
    }

    /**
     * @param string $message
     */
    public function info(string $message = ''): void
    {
        $this->log(LogLevel::INFO, $message);
    }

    /**
     * @param string $message
     */
    public function notice(string $message = ''): void
    {
        $this->log(LogLevel::NOTICE, $message);
    }

    /**
     * @param string $message
     */
    public function warning(string $message = ''): void
    {
        $this->log(LogLevel::WARNING, $message);
    }

    /**
     * @param string $level
     * @param string $message
     * @return string
     * Format LogLine
     */
    private function logLine(string $level, string $message): string
    {
        return $this->getTime() . "\t" . "[$level]" . "\t" . str_replace(\PHP_EOL, '   ', trim($message)) . PHP_EOL;
    }

    /**
     * @return string
     * Create a directory in project directory if it does not exist
     */
    private function createDirectory(): string
    {
        $dir = __DIR__ . "/var/log/";

        if (is_dir($dir) === false) {
            mkdir($dir, 0777, true);
        }
        return $dir;
    }
    public function getDirectory(): string
    {
        return $this->createDirectory();
    }
}