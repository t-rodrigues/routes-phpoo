<?php

namespace app\core;

class Controller
{
    private const NAMESPACE = 'app\controllers';

    public function execute(string $router)
    {
        if (!str_contains($router, '@')) {
            throw new \Exception('Invalid router');
        }

        list($controller, $method) = explode('@', $router);

        $controller = self::NAMESPACE . "\\{$controller}";

        if (!class_exists($controller)) {
            throw new \Exception("Controller {$controller} not found");
        }
        $controller = new $controller;

        if (!method_exists($controller, $method)) {
            throw new \Exception("method not found {$method}");
        }

        $params = new ControllerParams;
        $params = $params->get($router);

        $controller->$method($params);
    }
}
