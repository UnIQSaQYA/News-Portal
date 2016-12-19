<?php

$user = new user();

if (Input::method() && token::checkToken(Input::post('csrf_token'))) {
    $user->updateUser();
}
$id = Input::get('uid');
if (empty($id)) {
    redirect_to('user-list');

}
$db_user = $user->getUser($id);


if (empty($db_user)) {
    redirect_to('user-list');
}


?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-edit"></i> UPDATE USER</h2>
        <hr>


        <?php echo uploadErrors('alert alert-danger'); ?>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $db_user->id; ?>">
            <div class="form-group">
                <label for="uname">User Name</label>
                <input type="text" id="uname" class="form-control" value="<?= $db_user->uname; ?>" name="uname">
                <?= validationErrors('alert alert-danger', 'uname'); ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" value="<?= $db_user->email; ?>" name="email">
                <?= validationErrors('alert alert-danger', 'email'); ?>
            </div>

            <?php echo token::inputToken(); ?>

            <div class="form-group">
                <label for="uname">Old Password</label>
                <input type="password" id="oldpassword" class="form-control" name="oldpassword">
                <?= validationErrors('alert alert-danger', 'oldpassword'); ?>
            </div>

            <div class="form-group">
                <label for="uname">Password</label>
                <input type="password" id="password" class="form-control" name="password">
                <?= validationErrors('alert alert-danger', 'password'); ?>
            </div>


            <div class="form-group">
                <label for="">Confirm Password</label>
                <input type="password" id="cpassword" class="form-control" name="cpassword">
                <?= validationErrors('alert alert-danger', 'cpassword'); ?>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-10">
                        <input type="file" name="upload" class="form-control">
                    </div>
                    <div class="col-xs-2">
                        <img height="40" src="<?= $user->location . $db_user->upload; ?>" alt="<?= $db_user->upload ?>">
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="uname">Authentication Type</label>
                <select name="auth_type" id="" class="form-control">
                    <option value="" selected>-- Select Authentication Type --</option>
                    <option <?php if ($db_user->auth_type == "user") echo "selected"; else ""; ?> value="user">User
                    </option>
                    <option <?php if ($db_user->auth_type == "admin") echo "selected"; else ""; ?> value="admin">
                        Administrator
                    </option>
                </select>
                <?= validationErrors('alert alert-danger', 'auth_type'); ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success"><i class="fa fa-registered"></i> Update User</button>
            </div>


        </form>


    </div><!--end of div content-->


</div><!--end of container-fluid-->