<?php

namespace BlogApp\src\helpers;

class Pagination
{
    public static function createPagination($page, int $limit, int $count)
    {
        $page = (int)$page;
        $count = (int)ceil($count / $limit);
        if($page <= 0 || $page > $count || !$page) {
            $page = 1;
        }
        $offset = ($page * $limit) - $limit;

        return "LIMIT " . $offset . ", " . $limit;
    }
}