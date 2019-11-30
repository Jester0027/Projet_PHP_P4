<?php

namespace BlogApp\src;

use BlogApp\config\Router;

class Main
{
    public static function main()
    {
        $router = new Router();
        $router->run();
    }
}