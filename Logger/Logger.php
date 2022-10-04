<?php

class Logger
{

    private $filename;

    const DEFAULT_DATETIME_FORMAT = 'c';

    public const DEFAULT_FORMAT = '%timestamp% [%level%]: %message%';

    public function __construct($filename)
    {
        $dir = dirname($filename);

        if (!file_exists($dir)) {
            $status = @mkdir($dir, 0777, true);
        }

        $this->filename = $filename;
    }


    public function emergency($message, array $context = array())
    {
        $this->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => "EMERGENCY",
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }

    public function alert($message, array $context = array())
    {
        $this->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => "ALERT",
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }

    public function critical($message, array $context = array())
    {
        $this->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => "CRITICAL",
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }

    public function error($message, array $context = array())
    {
        $this->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => "ERROR",
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }

    public function warning($message, array $context = array())
    {
        $this->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => "ERROR",
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }

    public function notice($message, array $context = array())
    {
        $this->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => "NOTICE",
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }

    public function info($message, array $context = array())
    {
        $this->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => "INFO",
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }

    public function debug($message, array $context = array())
    {
        $this->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => "DEBUG",
            'timestamp' => (new \DateTimeImmutable())->format(self::DEFAULT_DATETIME_FORMAT),
        ]);
    }

    public function log($message, array $context = array())
    {
        $this->handle([
            'message' => self::interpolate((string)$message, $context),
            'level' => "LOG",
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