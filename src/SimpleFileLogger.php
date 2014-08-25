<?php

/**
 * PSR-3 compatible simple file logger.
 *
 * Writes log messages to file.
 */
class SimpleFileLogger
{

    const EMERGENCY = 'emergency';
    const ALERT = 'alert';
    const CRITICAL = 'critical';
    const ERROR = 'error';
    const WARNING = 'warning';
    const NOTICE = 'notice';
    const INFO = 'info';
    const DEBUG = 'debug';

    /**
     * Path to log file
     *
     * @var string
     */
    protected $file;

    /**
     * Class Contructor
     *
     * @param string $file Path to log file
     *
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function emergency($message, array $context = array())
    {
        $this->log(self::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function alert($message, array $context = array())
    {
        $this->log(self::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function critical($message, array $context = array())
    {
        $this->log(self::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function error($message, array $context = array())
    {
        $this->log(self::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function warning($message, array $context = array())
    {
        $this->log(self::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function notice($message, array $context = array())
    {
        $this->log(self::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function info($message, array $context = array())
    {
        $this->log(self::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return null
     */
    public function debug($message, array $context = array())
    {
        $this->log(self::DEBUG, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param string $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        if (!in_array($level, array(
            self::DEBUG, self::INFO, self::NOTICE,
            self::WARNING, self::ERROR, self::CRITICAL,
            self::ALERT, self::EMERGENCY))) {
            throw new InvalidArgumentException("Invalid log priority.");
        }
        $line = $this->formatMessage($level, $message, $context);
        $this->writeLog($line);
    }

    /**
     * Formats log message
     *
     * @param string $level Log level
     * @param string $message Log message
     * @param array $context Extra Data
     *
     * @return string Formatted log message
     */
    protected function formatMessage($level, $message, array $context = array())
    {
        $time = date('c');
        $context = json_encode($context);
        $message = trim($message);
        return "{$time} [{$level}] {$message} {$context}\n";
    }

    /**
     * Writes log message to file
     *
     * @param string $message Formatted log message
     *
     * @return boolean
     */
    protected function writeLog($message)
    {
        $handle = @fopen($this->file, 'ab');
        if ($handle === false) {
            throw new RuntimeException("Could not open log file {$this->file} for writing.");
        }
        $result = fwrite($handle, $message);
        if ($result === false) {
            throw new RuntimeException("Could write to log file {$this->file}.");
        }
        fclose($handle);
        return $result > 0;
    }
}
