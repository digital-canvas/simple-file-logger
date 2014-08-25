<?php

require_once(dirname(__DIR__) . '/src/SimpleFileLogger.php');

class SimpleFileLoggerTest extends PHPUnit_Framework_TestCase
{

    public function getLogger()
    {
        $file = 'php://output';
        $logger = new SimpleFileLogger($file);
        return $logger;
    }

    /**
     * @dataProvider provideLevelsAndMessages
     */
    public function testLogsAtAllLevels($level, $message)
    {

        $context = array('user' => 'Bob');
        $logger = $this->getLogger();
        ob_start();
        $logger->log($level, $message, $context);
        $log = ob_get_clean();

        $qlevel = preg_quote($level, "/");
        $qmessage = preg_quote($message, "/");
        $qcontext = preg_quote(json_encode($context), "/");
        $pattern = "/^\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2}[+-]\\d{2}:\\d{2} \\[{$qlevel}\\] {$qmessage} {$qcontext}\$/";

        $this->assertRegExp($pattern, $log);
    }

    /**
     * @dataProvider provideLevelsAndMessages
     */
    public function testLogFunctionsAtAllLevels($level, $message)
    {

        $context = array('user' => 'Bob');
        $logger = $this->getLogger();
        ob_start();
        $logger->{$level}($message, $context);
        $log = ob_get_clean();

        $qlevel = preg_quote($level, "/");
        $qmessage = preg_quote($message, "/");
        $qcontext = preg_quote(json_encode($context), "/");
        $pattern = "/^\\d{4}-\\d{2}-\\d{2}T\\d{2}:\\d{2}:\\d{2}[+-]\\d{2}:\\d{2} \\[{$qlevel}\\] {$qmessage} {$qcontext}\$/";

        $this->assertRegExp($pattern, $log);
    }

    public function provideLevelsAndMessages()
    {
        return array(
            SimpleFileLogger::EMERGENCY => array(SimpleFileLogger::EMERGENCY, 'message of level emergency'),
            SimpleFileLogger::ALERT => array(SimpleFileLogger::ALERT, 'message of level alert'),
            SimpleFileLogger::CRITICAL => array(SimpleFileLogger::CRITICAL, 'message of level critical'),
            SimpleFileLogger::ERROR => array(SimpleFileLogger::ERROR, 'message of level error'),
            SimpleFileLogger::WARNING => array(SimpleFileLogger::WARNING, 'message of level warning'),
            SimpleFileLogger::NOTICE => array(SimpleFileLogger::NOTICE, 'message of level notice'),
            SimpleFileLogger::INFO => array(SimpleFileLogger::INFO, 'message of level info'),
            SimpleFileLogger::DEBUG => array(SimpleFileLogger::DEBUG, 'message of level debug'),
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsOnInvalidLevel()
    {
        $logger = $this->getLogger();
        $logger->log('invalid level', 'Foo');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testNonWritableFile()
    {
        $file = __DIR__ . DIRECTORY_SEPARATOR . 'baddir' . DIRECTORY_SEPARATOR . 'badfile.log';
        $logger = new SimpleFileLogger($file);
        $logger->info("Cannot write to file");

    }
}
