<?php
require_once ('../Config/Config.php');
require_once(ROOT.'@admin@/Init/initialize.php');


if(array_key_exists('uid',$_GET)){
    $id=(int)Input::get('uid');
    $user=new user();
    if($user->deleteUser($id)){
        session::set('success','User was deleted successfully');
        redirect_to('user-list');
    }else{
        session::set('error','Could not delete the user ');
        redirect_to('user-list');
    }
}