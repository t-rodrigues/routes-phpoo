<?php

namespace app\core;

use app\routes\Routes;
use app\support\RequestType;
use app\support\Uri;

class ControllerParams
{
    private function filterParams(string $router): array
    {
        $uri = Uri::get();
        $explodeUri = explode('/', $uri);
        $explodeRouter = explode('/', $router);
        $params = [];
        foreach ($explodeRouter as $index => $routerSegment) {
            if ($routerSegment !== $explodeUri[$index]) {
                $params[] = $explodeUri[$index];
            }
        }

        return array_values($params);
    }

    public function get(string $router): array
    {
        $routes = Routes::get();
        $requestMethod = RequestType::get();
        $router = array_search($router, $routes[$requestMethod]);

        return $this->filterParams($router);
    }
}
