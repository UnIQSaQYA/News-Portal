<?php
/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/25/2016
 * Time: 1:53 PM
 */

session_start();

$serverName = $_SERVER['SERVER_NAME'];
define('VIRTUALHOST', 'virtualhostname.com');
if ($serverName == 'localhost' || $serverName == 'VIRTUALHOST') {
    define('ENVIRONMENT', 'development');

} else {
    define('ENVIRONMENT', 'production');
}

switch (ENVIRONMENT) {
    case 'development':
        ini_set('display_errors', 'on');
        error_reporting(-1);

        define('HTTP', 'http://' . $serverName . ':' . $_SERVER['SERVER_PORT'] . '/Php Class/Project/');
        define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/Php Class/Project/');
        define('ASSET', HTTP . 'public_html/');
        break;

    case 'production' :
        define('HTTP', 'changename');
        define('ROOT', 'changename');
        ini_set('display_errors', 'off');
        error_reporting(1);
        break;

    default :
        die('Unknown PLace');

}

$GLOBALS['config'] = [
                        'database' => [
                                        'host'=>'127.0.0.1',
                                        'dbname'=>'project',
                                        'user'=>'root',
                                        'password'=>''
                                       ],
                        'session'=> [
                                       'token'=>'csrf_token'

                                    ]
                        ];

$GLOBALS['restrictedPages']=['user-list','add-user','update-user'];
