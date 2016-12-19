<?php

/**{
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/29/2016
 * Time: 8:51 PM
 */


/**
 * Class Config
 */
class Config
{
    /** Function of a model that handles Database Connection's parameters dynamically
     * @param $getconfig
     * @return mixed
     */
    public static function getConfig($getconfig){
        $config=$GLOBALS['config'];
        $getconfig=explode('/',$getconfig);



        foreach ($getconfig as $item){
            if (isset($config[$item])){
                $config=$config[$item];

            }
        }

        return $config;
    }

}