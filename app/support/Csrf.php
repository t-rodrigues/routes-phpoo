<?php

namespace app\support;

use app\core\Request;
use Exception;

class Csrf
{
    public static function generateTokenCsrf(): string
    {
        if (isset($_SESSION['token'])) {
            unset($_SESSION['token']);
        }
        $token = md5(uniqid());
        $_SESSION['token'] = $token;
        return "<input type='hidden' name='token' value='{$token}'>";
    }

    public static function validateToken(): bool
    {
        if (!isset($_SESSION['token'])) {
            throw new Exception("Invalid token!!!!");
        }
        ['token' => $token] = Request::only('token');
        if (empty($token) || $_SESSION['token'] !== $token) {
            throw new Exception("Invalid token");
        }

        unset($_SESSION['token']);
        return true;
    }
}
