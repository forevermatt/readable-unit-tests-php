<?php
namespace ReadableUnitTests;

class BasicLogger extends \Sil\Psr3Adapters\LoggerBase
{
    /**
     * Log a message.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = [])
    {
        echo $this->interpolate($message, $context) . PHP_EOL;
    }
}
