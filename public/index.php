<?php

require '../vendor/autoload.php';

session_start();

$router = new BlogApp\config\Router();
$router->run();