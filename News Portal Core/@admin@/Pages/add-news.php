<?php

$cat=new category();
$categories= $cat->getCategory();

$objNews=new news();
if (Input::method() && token::checkToken(Input::post('csrf_token'))) {

    $objNews->addNews();
}


?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-newspaper-o"></i> ADD NEWS</h2>
        <hr>


        <form method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col-md-6 form-group">
                    <label for="">Category</label>
                    <select name="categoryId[]" id="categories" class="form-control" multiple>
                        <option value="" disabled>-- Choose Category --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= validationErrors('alert alert-danger', 'categoryId'); ?>
                </div>


                <div class="col-md-6 form-group">
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control">
                    <?= validationErrors('alert alert-danger', 'title'); ?>
                </div>

                <div class="col-md-6 form-group">
                    <label for="">Date</label>
                    <input type="text" id="newsdate" name="date" class="form-control">
                    <?= validationErrors('alert alert-danger', 'date'); ?>
                </div>

                <?= token::inputToken(); ?>

                <div class="col-md-6 form-group">
                    <label for="">New Priority</label>
                    <select name="priority" id="" class="form-control">

                        <?php if(!$objNews->isHighExist()) :?>
                        <option value="high">High</option>
                        <?php endif; ?>
                        <option value="low">Low</option>
                    </select>
                    <?= validationErrors('alert alert-danger', 'priority'); ?>
                </div>

                <div class="col-md-6 form-group">
                    <label for="">Upload Image</label>
                    <input type="file" name="upload" class=" form-control">
                    <?php echo uploadErrors('alert alert-danger'); ?>
                </div>

                <div class="col-md-6 form-group">
                    <label for=""></label>
                    <input type="hidden" disabled name="upload" class=" form-control">
                </div>

                <div class="col-md-12 form-group">
                    <label for="">Short Description</label>
                    <textarea rows="5" name="sDesc" id="" class="form-control"></textarea>
                    <?= validationErrors('alert alert-danger', 'sDesc'); ?>
                </div>


                <div class="col-md-12 form-group">
                    <label for="">Description</label>
                    <textarea rows="5" name="desc" class="form-control"></textarea>
                    <?= validationErrors('alert alert-danger', 'desc'); ?>
                </div>

                <div class="col-md-12 form-group">
                    <input type="submit" value="Create News" class="btn btn-success btn-lg btn-block">
                </div>


            </div>
        </form>


    </div><!--end of div content-->
<script>
    CKEDITOR.replace('desc');

</script>

</div><!--end of container-fluid-->