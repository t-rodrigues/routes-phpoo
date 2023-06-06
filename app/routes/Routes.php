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
                '/contact' => 'ContactController@index'
            ],
            'post' => [
                '/users/[0-9]+/update' => 'UserController@update',
                '/contact' => 'ContactController@store'
            ],
        ];
    }
}
