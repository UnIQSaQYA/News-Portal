<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 9/1/2016
 * Time: 12:34 PM
 */
class token
{
    private static function generateToken()
    {
        return session::set(Config::getConfig('session/token'), md5(uniqid()));
        
    }

    public static function checkToken($csrf_token)
    {

        if(session::exists(Config::getConfig('session/token')) && $csrf_token===session::get(Config::getConfig('session/token'))){
            session::delete(Config::getConfig('session/token'));
            return true;
        }
       return false;

    }


    public static function inputToken()
    {
        return "<input type='hidden' name='csrf_token' value='".self::generateToken()."' >";
    }
}