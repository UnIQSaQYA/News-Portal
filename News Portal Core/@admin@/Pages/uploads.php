<?php
$objUploads = new imageUpload();

if(Input::method()){
    $objUploads->deleteMultipleImages();
}


$id = Input::get('gid');
if (empty($id)) {
    redirect_to('gallery-cat');

}

$images = $objUploads->selectImages($id);


if (count($images)) {

    $catName = $images[0]->cat_name;
}


?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-picture-o"></i> Uploaded Images of <?= ucfirst($catName); ?></h2>
        <hr>
        <div class="gallery">
            <form method="post">
            <?php foreach ($images as $image): ?>
                <?php $for=rand();?>
                <li>
                  <a class="fancybox" rel="a" href="<?= $objUploads->location . $image->name; ?>"><img src="<?= $objUploads->location . $image->name; ?>" width="200" class="img-thumbnail"></a>
                    <label for="<?=$for?>"> <input type="checkbox" id="<?=$for?>" value="<?=$image->id;?>" name="upId[]" class="checkbox">
                    </label>
                </li>
            <?php endforeach; ?>

            <div class="clearfix"></div>
            <button type="submit" class="btn btn-danger btn-lg "><i class="fa fa-trash-o"></i> Delete</button>
            </form>
        </div>

        <div class="pull-right">
            <?php //= $objNews->pagination; ?>
        </div>
        <div class="clearfix"></div>

    </div><!--end of div content-->


</div><!--end of container-fluid-->