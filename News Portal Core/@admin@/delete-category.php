<?php
require_once ('../Config/Config.php');
require_once(ROOT.'@admin@/Init/initialize.php');


if(array_key_exists('id',$_GET)){

    $id=(int)Input::get('id');
    $delNews=new News();
    if($delNews->delNews($id)){
        session::set('success','News was deleted successfully');
        redirect_to('news-list');
    }else{
        session::set('error','Could not delete news ');
        redirect_to('news-list');
    }
}