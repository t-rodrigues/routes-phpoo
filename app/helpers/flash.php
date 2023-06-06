<?php

use app\support\Flash;

function flash(string $index, string $css = ''): string
{
    $message = Flash::get($index);
    $flash = "<div class='alert alert-primary {$css}' role='alert'>";
    $flash .= "<span class=''>{$message}</span>";
    $flash .= "</div>";
    return $flash;
}
