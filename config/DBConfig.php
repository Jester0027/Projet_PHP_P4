<?php

namespace BlogApp\config;

interface DBConfig
{
    const HOST = 'localhost';
    const DB_NAME = 'ocnoumeasm165';
    const CHARSET = 'utf8';
    const DB_HOST = 'mysql:host=' . self::HOST . ';dbname=' . self::DB_NAME . ';charset=' . self::CHARSET;
    const DB_USER = 'root';
    const DB_PW = '';
}
