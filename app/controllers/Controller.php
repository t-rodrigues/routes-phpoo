<?php

namespace app\controllers;

use League\Plates\Engine;

abstract class Controller
{
    protected static function view(string $view, array $data = [])
    {
        $viewPath = "../app/views/{$view}.php";

        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: {$view}");
        }

        $template = new Engine("../app/views");
        echo $template->render($view, $data);
    }
}
