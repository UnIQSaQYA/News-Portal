<?php

$galleryCat = new galleryCategory();
$categories=$galleryCat->getCategory();
//echo "<pre>";
//print_r($categories);

if (Input::method() && token::checkToken(Input::post('csrf_token'))) {
   $objUpload= new imageUpload();
    $objUpload->uploadImage();
}


?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-upload"></i> UPLOAD IMAGE</h2>
        <hr>
        <?=sessionDisplayMessage();?>
        <?=uploadErrors('alert alert-danger');?>


        <form method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="uname">Choose Category</label>
                <select name="category" id="" class="form-control">
                    <?php foreach ($categories as $category): ?>
                    <option value="<?=$category->id?>"><?=$category->name; ?></option>
                    <?php endforeach;?>
                </select>
                <?= validationErrors('alert alert-danger', 'upload_category_name'); ?>
            </div>

            <div class="form-group">
                <label for="uname">Upload Image Name</label>
                <input type="file" id="upload" multiple class="form-control" value="" name="upload[]">
                <?= validationErrors('alert alert-danger', 'upload_category_name'); ?>
            </div>


            <?php echo token::inputToken(); ?>






            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="fa fa-registered"></i> Upload</button>
            </div>


        </form>


    </div><!--end of div content-->


</div><!--end of container-fluid-->