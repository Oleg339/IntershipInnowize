<?php

namespace Model;

use Psr\Log\LogLevel;
use Task18\Logger;

class Ban
{
    const TABLE = "Ban";

    const FIELDS = ['ip', 'time'];

    private $ip;

    private $time;

    const DURATION = '15 minutes';

    private $id;

    public function __construct($data)
    {
        $this->ip = $data['ip'];

        if (!array_key_exists('id', $data)) {
            $logger = new Logger('logs/Task18_' . date_create()->format('dmY') . '.log');

            $logger->log(
                LogLevel::NOTICE,
                'User with ip {ip} was banned for {date_start}-{date_end} for trying to enter in {email} account',
                [
                    'ip' => $data['ip'], 'date_start' => date('d-m-y h:i:s'),
                    'date_end' => date('d-m-y h:i:s', strtotime(date('d-m-y h:i:s') . '+' . self::DURATION)),
                    'email' => $data['email']
                ]
            );

            return;
        }

        $this->id = $data['id'];
    }

    public function save()
    {
        $this->id = Database::store($this);
    }


    public function getValues()
    {
        return ['ip' => $this->ip,
            'time' => $this->time ?: date('d-m-y h:i:s')];
    }

    public static function get($ip)
    {
        $ban = Database::find(self::class, 'ip', $ip);

        if (!$ban) {
            return false;
        }

        if (strtotime($ban['time'] . '+' . self::DURATION) < strtotime(date('d-m-y h:i:s'))) {
            Database::delete(new Ban($ban));
            return false;
        }

        return true;
    }

    public function getId()
    {
        return $this->id;
    }
}