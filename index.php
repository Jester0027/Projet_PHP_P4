<?php

require './config/dev.php';
require './vendor/autoload.php';

session_start();

BlogApp\src\Main::main();