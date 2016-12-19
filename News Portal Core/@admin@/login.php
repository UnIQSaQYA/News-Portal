<?php
require_once('../Config/Config.php');
require_once(ROOT . '@admin@/Init/initialize.php');
require_once(ROOT . '@admin@/Pages/layout/header.php');

if(Input::method()){
    $user=new User();
    $user->login();
}

?>


    <style>
        body {
            background: white;
        }
    </style>
    <div class="container">
        <?php echo validationErrors('alert alert-danger'); ?>
        <?php echo sessionDisplayMessage(); ?>
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-lg login-btn" data-toggle="modal" data-target="#myModal">
        Login to Dashboard
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">User Credentials</h4>
                </div>

                <form class="" method="post">
                    <div class="modal-body">

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                <input type="text" class="form-control" id="" name="email" placeholder="Input Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                <input type="password" class="form-control" name="password" id="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-apple"></i></div>
                                <select name="auth_type" id="" class="form-control">
                                    <option value=""  >--Select Authentication Type--</option>
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


<?php require_once(ROOT . '@admin@/Pages/layout/footer.php'); ?>