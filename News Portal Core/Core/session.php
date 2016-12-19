<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/31/2016
 * Time: 2:00 PM
 */
class session
{

    public static function set($key="",$value){
        if(empty($key))return false;

        return $_SESSION[$key]=$value;
    }
    
    

    public static function get($key=""){
        if(empty($key))return false;
        
        if(self::exists($key)){
            return $_SESSION[$key];
        }
        return "";
    }
    
    

    public static function exists($key=""){
        if(empty($key)) return false;

        return isset($_SESSION[$key]);
    }
    
    
    

    public static function delete($key=''){
        if(empty($key))return false;

        if(self::exists($key)){
            unset($_SESSION[$key]);
        }

    }

    /**sets the login credentials in session
     * @param array $userData
     */
    public static function userData(array $userData){
        if(empty($userData)) return;

            foreach ($userData as $key=>$value){
                self::set($key,$value);
            }

    }


    /**
     * It prohibits the user to bypass login page and if tried redirects to login page
     */
    public static function isLoggedIn(){
        if(!self::exists('is_logged_in')&& self::get('is_logged_in')!==true){
            header('location:login.php');
            exit;
        }
    }

    /** Prohibiting user to access admin functionalities
     * @return bool
     */
    public static function isAdmin(){
        if(self::exists('auth_type')&& self::get('auth_type')=='admin'){
            return true;
        }else
            return false;

    }


}