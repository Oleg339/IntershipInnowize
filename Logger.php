<?php

namespace Task18;

require_once __DIR__ . '/vendor/autoload.php';

use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
    private $filename;

    const DEFAULT_DATETIME_FORMAT = 'c';

    public const DEFAULT_FORMAT = '%timestamp% [%level%]: %message%';

    public function __construct($filename)
    {
        $dir = dirname($filename);

        if (!file_exists($dir)) {
            @mkdir($dir, 0777, true);
        }

        $this->filename = $filename;
    }

    public function log($level, $message, array $context = array()): void
    {
        $this->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => strtoupper($level),
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }

    protected static function interpolate(string $message, array $context = []): string
    {
        $replace = [];
        foreach ($context as $key => $val) {
            if (is_string($val) || method_exists($val, '__toString')) {
                $replace['{' . $key . '}'] = $val;
            }
        }
        return strtr($message, $replace);
    }

    public function handle(array $vars): void
    {
        $output = self::DEFAULT_FORMAT;

        foreach ($vars as $var => $val) {
            $output = str_replace('%' . $var . '%', $val, $output);
        }

        file_put_contents($this->filename, $output . PHP_EOL, FILE_APPEND);
    }
}