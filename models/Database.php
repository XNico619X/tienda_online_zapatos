<?php
require_once __DIR__ . '/../config.php';

class Database
{
    private static ?mysqli $connection = null;

    public static function connect(): mysqli
    {
        if (self::$connection === null) {
            self::$connection = db_connect();
        }

        return self::$connection;
    }
}
