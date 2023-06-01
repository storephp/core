<?php

namespace Store\Base;

class ModelConnection
{
    public static $connection = null;

    public static function setConnection($connection)
    {
        static::$connection = $connection;
    }

    public static function getConnection()
    {
        return static::$connection;
    }
}
