<?php

namespace app\routes;

class Routes
{
    public static function get()
    {
        return [
            'get' => [
                '/' => 'HomeController@index',
                '/users' => 'UserController@index',
                '/users/[0-9]+' => 'UserController@show',
                '/users/[0-9]+/edit' => 'UserController@edit',
            ],
            'post' => [],
        ];
    }
}
