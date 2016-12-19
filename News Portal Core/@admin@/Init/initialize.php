<?php
/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/28/2016
 * Time: 8:58 PM
 * @param $className
 */

function autoload($className)
{
    $libPath = ROOT . '@admin@/LIB/' . $className . '.php';
    $configPath = ROOT . 'Core/' . $className . '.php';
    $modelPath=ROOT.'Core/Model/'.$className.'.php';
    if (file_exists($libPath) && is_file($libPath)) {
        require_once($libPath);
    } elseif (file_exists($configPath) && is_file($configPath)) {
        require_once($configPath);
    }elseif (file_exists($modelPath) && is_file($modelPath)){
        require_once ($modelPath);
    } else {
        die("$className not found!!!!");
    }


}

spl_autoload_register('autoload');

require_once (ROOT.'Helper/functions.php');