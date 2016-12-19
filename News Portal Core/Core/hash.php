<?php

/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/31/2016
 * Time: 1:03 PM
 */
class hash
{
    /**Ecnrypts the password field in form
     * @param string $password
     * @return bool|string
     */
    public static function passwordEndcrypt($password = "")
    {
        if (empty($password)) return false;
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /** Verifes the given password th the encrypted hash password
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function passwordVerify($password, $hash)
    {
        return password_verify($password, $hash);
    }

}