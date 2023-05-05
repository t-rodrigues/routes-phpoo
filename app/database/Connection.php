<?php

namespace app\database;

use PDO;

class Connection
{
    private static ?PDO $connection = null;

    public static function connect()
    {
        if (!self::$connection) {
            $dsn = "mysql:host=127.0.0.1;dbname=routes_phpoo";
            $user = 'docker';
            $pass = 'docker';
            self::$connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);
        }
        return self::$connection;
    }
}
