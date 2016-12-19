<?php

//print_r($_POST);
//echo json_encode($_POST);

require_once '../Config/config.php';
require_once ROOT.'@admin@/Init/initialize.php';


if((isset($_POST['do']) && !empty($_POST['do'])) || (isset($_GET['do']) && !empty($_GET['do']))){
    $ajax=new Ajax();
    if(isset($_POST['do'])){
        $do=$_POST['do'];
    }elseif(isset($_GET['do'])){
        $do=$_GET['do'];
    }

    switch($do){
        case 'insert-ajax-data':
            //insert into db
            $ajax->saveData();
            break;
        case 'get-ajax-data':
            //get data
            $ajax->getAjaxData();
            break;
        case 'delete-ajax':
            $ajax->deleteAjaxRow();
            break;
        case 'edit-ajax':
            $ajax->editAjax();
            break;
        case 'update-ajax-action':
            $ajax->updateAjaxAction();
            break;


    }

}

