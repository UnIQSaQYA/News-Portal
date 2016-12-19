<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/29/2016
 * Time: 10:06 PM
 */
class Input
{
    public static function method($method = 'post')
    {
        if (empty($method)) return false;
        switch ($method) {
            case 'post' :
                if (!empty($_POST) && $_SERVER['REQUEST_METHOD'] = 'post') {
                    return true;
                }
                break;

            case 'get':
                if (!empty($_GET) && $_SERVER['REQUEST_METHOD'] = 'get') {
                    return true;
                }

        }

        return false;


    }

    /**
     * @param null $key
     * @return bool|string
     */
    public static function post($key = NULL)
    {
        if (!isset($key)) return false;

        if (isset($_POST[$key])) {
            return $_POST[$key];
        }

    }


    public static function get($key = NULL)
    {
        if (!isset($key)) return false;

        if (isset($_GET[$key])) {
            return $_GET[$key];
            return "";
        }

    }

}