<?php


$objNews = new news();
$newsCat = $objNews->getNews();

if (Input::method()) {
    $objNews->setPriority();
}

// $sn GIVES THE PROPER SERIAL NUMBER IN TABLE
$sn=(pagination::$_current_page*pagination::$_limit)-pagination::$_limit;

?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-newspaper-o"></i> NEWS</h2>
        <hr>
        <?php
        echo sessionDisplayMessage();
        ?>

        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th width="7%">S.no</th>
                <th>Title</th>
                <th width="10%">Image</th>
                <th width="10%">User</th>
                <th width="15%">Categories</th>
                <th width="10%">Action</th>
                <th width="10%">Set Priority</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($newsCat as $key => $value): ?>


                <tr>
                    <td><?= $sn+=1; ?></td>
                    <td><?= '<b>' . ucfirst($value->title) . '</b>' ?></td>
                    <td><img src="<?= $objNews->upload_location . $value->image ?>" height="40"></td>
                    <td><?= ucfirst($value->uname); ?> </td>
                    <td>
                        <?php
                        $cat = explode(',', $value->cat);
                        $labelClass = ['danger', 'info', 'primary', 'success', 'warning', 'default'];
                        foreach ($cat as $key2 => $catName) {
                            $i=rand(0,5);
                            echo "<span class='label label-{$labelClass[$i]}'>" . $catName . "<br></span>";
                        }
                        ?>
                    </td>
                    <td>
                        <a href="delete-category.php?id=<?=$value->id;?>"<i class="fa fa-trash fa-2x"></i> </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href=""><i class="fa fa-edit fa-2x"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    </td>
                    <td>

                        <form method="post">
                            <input type="hidden" name="id" value="<?= $value->id ?>">
                            <?php if ($value->priority == 'low') { ?>
                                <input type="submit" class="btn btn-info " name="priority" value="High" >
                            <?php } else { ?>
                                <input type="submit" class="btn btn-info" name="priority" value="Low">
                            <?php } ?>
                        </form>


<!--                        --><?php //if ($value->priority !== 'high') { ?>
<!--                            <a href="">Change Priority <i class="fa fa-level-up fa-2x"></i></a>-->
<!--                        --><?php //} else { ?>
<!--                            <a href="">Change Priority <i class="fa fa-level-down fa-2x"></i></a>-->
<!--                        --><?php //} ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pull-right">
            <?= $objNews->pagination; ?>
        </div>
        <div class="clearfix"></div>

    </div><!--end of div content-->


</div><!--end of container-fluid-->