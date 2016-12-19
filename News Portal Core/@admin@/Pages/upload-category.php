<?php

$galleryCat = new galleryCategory();

if (Input::method() && token::checkToken(Input::post('csrf_token'))) {
    $galleryCat->addCategory();
}


?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-upload"></i> UPLOAD CATEGORY</h2>
        <hr>
        <?=sessionDisplayMessage()?>


        <form method="post" >

            <div class="form-group">
                <label for="uname">Upload Category Name</label>
                <input type="text" id="upload_category_name" class="form-control" value="" name="upload_category_name">
                <?= validationErrors('alert alert-danger', 'upload_category_name'); ?>
            </div>


            <?php echo token::inputToken(); ?>






            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="fa fa-registered"></i> Create Category</button>
            </div>


        </form>


    </div><!--end of div content-->


</div><!--end of container-fluid-->