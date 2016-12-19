<?php
$objCategory=new galleryCategory();
$galleryCat=$objCategory->getCategoryImageNo();


// $sn GIVES THE PROPER SERIAL NUMBER IN TABLE
$sn=(pagination::$_current_page*pagination::$_limit)-pagination::$_limit;

?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-picture-o"></i> Gallery Category</h2>
        <hr>
        <?php
        echo sessionDisplayMessage();
        ?>

        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th width="7%">S.no</th>
                <th>Category Name</th>
                <th width="10%">No of Image</th>
                <th width="10%">Action</th>


            </tr>
            </thead>

            <tbody>
            <?php foreach ($galleryCat as $key => $gallery): ?>


                <tr>
                    <td><?=$sn+=1; ?></td>
                    <td><?='<b>'.$gallery->name.'</b>';?></td>
                    <td><?=$gallery->img_count;?></td>
                    <td><a href="main_layout.php?page=uploads&gid=<?=$gallery->id; ?>" class="btn btn-success" <?=($gallery->img_count==0)? 'disabled' : '' ;?>>Go To Gallery</a> </td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pull-right">
            <?php //= $objNews->pagination; ?>
        </div>
        <div class="clearfix"></div>

    </div><!--end of div content-->


</div><!--end of container-fluid-->