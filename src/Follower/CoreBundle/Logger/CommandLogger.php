<?php
namespace Follower\CoreBundle\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\Output;

/**
 * Created by PhpStorm.
 * User: hursit_topal
 * Date: 12/11/16
 * Time: 15:24
 */
class CommandLogger implements LoggerInterface
{
    CONST NEWLINE = "\n";

    /** @var  ConsoleOutput $output */
    protected $output;

    static $COLORS = [
        'EMERGENCY' => 'red',
        'ALERT' => 'red',
        'CRITICAL' => 'red',
        'ERROR' => 'red',
        'WARNING' => 'red',
        'NOTICE' => 'yellow',
        'INFO' => 'yellow',
        'SUCCESS' => 'green',
        'DEBUG' => 'gray',
    ];

    static $FONT_WEIGHTS = [
        'EMERGENCY' => 'bold',
        'ALERT' => 'bold',
        'CRITICAL' => 'bold',
        'ERROR' => 'bold',
        'WARNING' => null,
        'NOTICE' => null,
        'INFO' => null,
        'SUCCESS' => null,
        'DEBUG' => null,
    ];

    /**
     * CommandLogger constructor.
     * @param ConsoleOutput $output
     */
    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }


    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        $this->log(strtoupper(__FUNCTION__), $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = array())
    {
        $this->log(strtoupper(__FUNCTION__), $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = array())
    {
        $this->log(strtoupper(__FUNCTION__), $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = array())
    {
        $this->log(strtoupper(__FUNCTION__), $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = array())
    {
        $this->log(strtoupper(__FUNCTION__), $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = array())
    {
        $this->log(strtoupper(__FUNCTION__), $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = array())
    {
        $this->log(strtoupper(__FUNCTION__), $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function success($message, array $context = array())
    {
        $this->log(strtoupper(__FUNCTION__), $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = array())
    {
        $this->log(strtoupper(__FUNCTION__), $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $message = '[' . $level . '] [' . date('Y-m-d H:i:s') . ']' . $message . ' ' . json_encode($context);

        $this->output->writeln("<fg=" . self::$COLORS[$level] . ";options=" . self::$FONT_WEIGHTS[$level] . ">$message</>");
    }
}