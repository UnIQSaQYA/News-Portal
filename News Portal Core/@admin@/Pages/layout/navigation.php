
<div class="nav">
    <div class="nav-top">
        <img src="<?= ASSET;?>img/user/<?=ucfirst(session::get('logged_user_image'))?>">
        <h4><?=ucfirst(session::get('logged_user_name'))?></h4>
        <p><?=ucfirst(session::get('logged_user_email'))?></p>
    </div>

    <div class="navlinks">
        <div class="search-box">
            <form>
                <input type="text" class="search" placeholder="Search">
            </form>
        </div>
        <div class="menu">
            <ul>
                <li><a href="main_layout.php?page=dashboard"><i class="glyphicon glyphicon-cloud"> </i> Dashboard</a></li>
                <?php if(session::isAdmin()){ ?>
                <li class="drop-down"><a href=""><i class="glyphicon glyphicon-user"> </i>  Users</a>
                    <ul>
                        <li><a href="main_layout.php?page=add-user"><i class="fa fa-plus"></i> Add User</a></li>
                        <li><a href="main_layout.php?page=user-list"><i class="fa fa-user"></i> Users</a></li>
                    </ul>
                </li>
                <?php } ?>

                <li class="drop-down"><a href=""><i class="glyphicon glyphicon-user"> </i>  Gallery</a>
                    <ul>
                        <li><a href="main_layout.php?page=upload-category"><i class="fa fa-plus"></i> ADD Category</a></li>
                        <li><a href="main_layout.php?page=upload-image"><i class="fa fa-user"></i>Upload Image</a></li>
                        <li><a href="main_layout.php?page=gallery-cat"><i class="fa fa-user"></i>View Categories</a></li>
                    </ul>
                </li>

                <li class="drop-down"><a href=""><i class="glyphicon glyphicon-new-window"> </i>  News</a>
                    <ul>
                        <li><a href="main_layout.php?page=add-news"><i class="fa fa-plus"></i> Add News</a></li>
                        <li><a href="main_layout.php?page=add-category"><i class="fa fa-plus"></i> Add News Category</a></li>
                        <li><a href="main_layout.php?page=news-list"><i class="fa fa-newspaper-o"></i> News List</a></li>
                    </ul>
                </li>
                <li><a href=""><i class="glyphicon glyphicon-globe"> </i>  Visit Site</a></li>
                <li><a href="main_layout.php?page=ajax-crud"><i class="glyphicon glyphicon-globe"> </i>  AJAX</a></li>
                <li><a href=""><i class="glyphicon glyphicon-log-out"> </i>  Log Out</a></li>
            </ul>
        </div>
    </div>
</div><!--end of navigation-->
