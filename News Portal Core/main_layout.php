<?php

    require_once ('Config/Config.php');

    $page='Home';
    if((isset($_GET['page'])) & !empty($_GET['page'])){
        $page=$_GET['page'];
    }
    $page.='.php';

?>



<?php require_once('Pages/layout/header.php'); ?>

<?php
    $files='Pages/'.$page;
    if(file_exists($files)){
        require_once ($files);
    }else{
        echo "File Not Found ".$page;
    }


?>
<?php require_once ('Pages/layout/footer.php'); ?>