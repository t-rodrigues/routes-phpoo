<?php

namespace app\core;

use Exception;

class Request
{
    public static function all()
    {
        return $_POST;
    }

    public static function input(string $input): string
    {
        if (!isset($_POST[$input])) {
            throw new Exception("input not found: {$input}");
        }
        return $_POST[$input];
    }

    public static function only(string|array $only): array
    {
        $fieldsPost = self::all();
        $arr = [];

        if (is_string($only)) {
            if (array_key_exists($only, $fieldsPost)) {
                $arr[$only] = $fieldsPost[$only];
            }
            return $arr;
        }

        if (is_array($only)) {
            foreach ($only as $key) {
                if (isset($fieldsPost[$key])) {
                    $arr[$key] = $fieldsPost[$key];
                }
            }
        }

        return $arr;
    }

    public static function excepts(string|array $excepts): array
    {
        $fieldsPost = self::all();

        if (is_array($excepts)) {
            foreach ($excepts as $index => $key) {
                if (isset($fieldsPost[$key])) {
                    unset($fieldsPost[$key]);
                }
            }
            return $fieldsPost;
        }

        if (array_key_exists($excepts, $fieldsPost)) {
            unset($fieldsPost[$excepts]);
        }

        return $fieldsPost;
    }

    public static function query($name)
    {
        if (!isset($_GET[$name])) {
            throw new Exception("Não existe a query string: {$name}");
        }

        return $_GET[$name];
    }

    public static function toJson(array $payload): string
    {
        return json_encode($payload);
    }

    public static function toArray(string $json)
    {
        if (!isJson($json)) {
            throw new Exception("invalid json");
        }

        return json_decode($json);
    }
}
