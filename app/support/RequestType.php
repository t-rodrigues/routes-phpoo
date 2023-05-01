<?php

namespace app\support;

class RequestType
{
    public static function get(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
