<?php


$objUser = new user();
$users = $objUser->getUser();
if (Input::method()) {
    $objUser->changeUserStatus();
}
// $sn GIVES THE PROPER SERIAL NUMBER IN TABLE
$sn=(pagination::$_current_page*pagination::$_limit)-pagination::$_limit;
?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-user"></i> USERS</h2>
        <hr>
        <?php
        echo sessionDisplayMessage();
        ?>

        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th width="10%">S.no</th>
                <th>User Name</th>
                <th>Email</th>
                <th width="10%">Action</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($users as $key => $user): ?>
                <tr>
                    <td><?php
                        echo $sn+=1 ;?></td>
                    <td><?= ucfirst($user->uname); ?><?php echo ($user->auth_type !== 'user') ? "<i class='glyphicon glyphicon-user'></i>" : " " ?></td>
                    <td><?= $user->email; ?></td>
                    <td>
                        <a href="delete.php?uid=<?= $user->id; ?>"<i class="glyphicon glyphicon-trash"></i> </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="main_layout.php?page=update-user&uid=<?= $user->id; ?>"><i
                                class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php if ($user->auth_type == 'user') { ?>
                            <form method="post">
                                <input type="hidden" name="id" value="<?= $user->id ?>">
                                <?php if ($user->user_status == 'disable') { ?>
                                    <input type="submit" class="btn btn-default btn-xs" name="action" value="Enable">
                                <?php } else { ?>
                                    <input type="submit" class="btn btn-default btn-xs" name="action" value="Disable">
                                <?php } ?>
                            </form>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pull-right">
            <?= $objUser->pagination; ?>
        </div>
        <div class="clearfix"></div>

    </div><!--end of div content-->


</div><!--end of container-fluid-->