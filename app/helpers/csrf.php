<?php

use app\support\Csrf;

function getToken(): string
{
    return Csrf::generateTokenCsrf();
}
