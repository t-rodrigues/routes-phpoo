<?php

use app\core\Router;
use Dotenv\Dotenv;

require '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

session_start();

Router::run();
