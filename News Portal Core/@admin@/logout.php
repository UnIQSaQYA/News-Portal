<?php
/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 9/7/2016
 * Time: 2:21 PM
 */
session_start();
session_destroy();
header('location:login.php');