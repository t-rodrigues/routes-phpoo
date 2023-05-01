<?php

function isJson(string $json): bool
{
    json_decode($json);

    return json_last_error() === JSON_ERROR_NONE;
}
