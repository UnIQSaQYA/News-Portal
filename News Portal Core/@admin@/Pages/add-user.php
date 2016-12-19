<?php

$user = new user();

if (Input::method() && token::checkToken(Input::post('csrf_token'))) {
    $user->addUser();
}


?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-plus"></i> ADD USER</h2>
        <hr>


        <?php echo uploadErrors('alert alert-danger'); ?>
        <form method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="uname">User Name</label>
                <input type="text" id="uname" class="form-control" value="<?= errorFields('uname'); ?>" name="uname">
                <?= validationErrors('alert alert-danger', 'uname'); ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" value="<?= errorFields('email'); ?>" name="email">
                <?= validationErrors('alert alert-danger', 'email'); ?>
            </div>

            <?php echo token::inputToken(); ?>
            <div class="form-group">
                <label for="uname">Password</label>
                <input type="password" id="password" class="form-control" value="<?= errorFields('password'); ?>"
                       name="password">
                <?= validationErrors('alert alert-danger', 'password'); ?>
            </div>


            <div class="form-group">
                <label for="">Confirm Password</label>
                <input type="password" id="cpassword" class="form-control" value="<?= errorFields('cpassword'); ?>"
                       name="cpassword">
                <?= validationErrors('alert alert-danger', 'cpassword'); ?>
            </div>

            <div class="form-group">
                <input type="file" name="upload" class="form-control">
            </div>


            <div class="form-group">
                <label for="uname">Authentication Type</label>
                <select name="auth_type" id="" class="form-control">
                    <option value="" selected>-- Select Authentication Type --</option>
                    <option <?= selectErrorField('user', 'auth_type') ?> value="user">User</option>
                    <option <?= selectErrorField('admin', 'auth_type') ?>value="admin">Administrator</option>
                </select>
                <?= validationErrors('alert alert-danger', 'auth_type'); ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="fa fa-registered"></i> Register User</button>
            </div>


        </form>


    </div><!--end of div content-->


</div><!--end of container-fluid-->