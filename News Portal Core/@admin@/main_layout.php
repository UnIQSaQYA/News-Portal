<?php
/**
 * Created by PhpStorm.
 * User: Santosh
 * Date: 8/28/2016
 * Time: 11:57 AM
 */

require_once('../Config/Config.php');
require_once(ROOT . '@admin@/Init/initialize.php');

session::isLoggedIn();


$page = 'dashboard';

if ((isset($_GET['page'])) & !empty($_GET['page'])) {
    $page = $_GET['page'];
}
$title = $page;
$page .= '.php';

?>

<?php require_once(ROOT . '@admin@/Pages/layout/header.php'); ?>

<?php require_once(ROOT.'@admin@/Pages/layout/top-bar.php'); ?>

<?php require_once(ROOT.'@admin@/Pages/layout/navigation.php'); ?>
<?php

if(session::get('auth_type')=='user' && in_array($_GET['page'],$GLOBALS['restrictedPages'])){
    redirect_to('dashboard');

}
$files = ROOT . '@admin@/Pages/' . $page;
if (file_exists($files)) {
    require_once($files);
} else {
    echo "File Not Found " . $page;
}


?>
<?php require_once(ROOT . '@admin@/Pages/layout/footer.php'); ?>
