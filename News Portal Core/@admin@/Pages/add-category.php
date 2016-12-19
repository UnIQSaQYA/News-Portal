<?php

$cat = new category();

if (Input::method() && token::checkToken(Input::post('csrf_token'))) {
    $cat->addCategory();
}


?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-clipboard"></i> ADD CATEGORY</h2>
        <hr>
        <?=sessionDisplayMessage()?>


        <form method="post" >

            <div class="form-group">
                <label for="uname">Category Name</label>
                <input type="text" id="category_name" class="form-control" value="" name="category_name">
                <?= validationErrors('alert alert-danger', 'category_name'); ?>
            </div>


            <?php echo token::inputToken(); ?>






            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="fa fa-registered"></i> Create Category</button>
            </div>


        </form>


    </div><!--end of div content-->


</div><!--end of container-fluid-->