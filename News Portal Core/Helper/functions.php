<?php
/**Redirects to the location sent through parameter
 * @param $location
 */


function redirect_to($location = "")
{
    if (empty($location)) return false;

    header("Location: main_layout.php?page=" . $location);
    exit;
}


function validationErrors($className = '', $particular = null)
{
    $output = "";
    if (!isset($particular)) {
        if (session::exists('validationErrors')) {
            foreach (session::get('validationErrors') as $error) {
                $output .= "<div class='{$className}'>";
                $output .= $error;
                $output .= "</div>";
            }
            session::delete('validationErrors');
            return $output;
        }
        return "";
    } else {
        if (session::exists('validationErrors')) {

            $sessionErrors = session::get('validationErrors');
            if (isset($sessionErrors[$particular])) {
                $output .= "<div class='$className'> <i class='glyphicon glyphicon-warning-sign'></i>&nbsp;&nbsp;&nbsp; ";
                $output .= $sessionErrors[$particular];
                $output .= "</div>";
                unset($_SESSION['validationErrors'][$particular]);
                return $output;
            }

        }
    }
}

function errorFields($fieldName = "")
{
    $output = '';
    if (session::exists($fieldName)) {
        $output .= $_SESSION[$fieldName];
        session::delete($fieldName);
    }
    return $output;
}


function selectErrorField($fieldName = "", $selectName = "")
{

    if (isset($_SESSION[$selectName])) {
        if ($fieldName == $_SESSION[$selectName]) {
            session::delete($selectName);
            return "selected";
        } else {
            return "";
        }
    } else {
        return "";
    }
}


function sessionDisplayMessage()
{
    $output = '';
    if (session::exists('success')) {
        $output .= "<div class='alert alert-success'>";
        $output .= session::get('success');
        $output .= "</div>";
        session::delete('success');
    } else if (session::exists('error')) {
        $output .= "<div class='alert alert-danger'>";
        $output .= session::get('error');
        $output .= "</div>";
        session::delete('error');
    }
    return $output;
}


function uploadErrors($className)
{
    $output = "";
    if (Session::exists('uploadErrors')) {
        $sessionErrors = Session::get('uploadErrors');
        foreach ($sessionErrors as $error) {
            $output .= "<div class='{$className}'> 
                            <i class='glyphicon glyphicon-warning-sign'></i>&nbsp;&nbsp;&nbsp; ";
            $output .= $error;
            $output .= "</div>";
        }
        Session::delete('uploadErrors');
    }
    return $output;
}

