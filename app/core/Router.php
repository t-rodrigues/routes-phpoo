<?php

namespace app\core;

class Router
{
    public static function run()
    {
        try {
            $routerRegistered = new RoutersFilter;
            $router = $routerRegistered->get();

            $controller = new Controller;
            $controller->execute($router);

            dd($router);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
