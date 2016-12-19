<?php

?>


<div class="container-fluid">

    <div class="content">

        <h2><i class="fa fa-newspaper-o"></i> AJAX CRUD <span id="action-type"></span></h2>
        <hr>

        <form action="" id="ajax_form">


            <div class="form-group">
                <label>Name</label>
                <input type="text" name="txtname" id="name" class="form-control">
            </div>

            <div class="form-group">
                <label>Age</label>
                <input type="text" name="txtage" id="age" class="form-control">
            </div>

            <div class="form-group">
                <label>Gender</label><br>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-primary active">
                        <input type="radio" name="txtgender" value="male" id="male" autocomplete="off" checked> Male
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="txtgender" value="female" id="female" autocomplete="off"> Female
                    </label>

                </div>
            </div>






            <div class="form-group">
                <label>Language</label><br>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-success active">
                        <input type="checkbox" name="txtlang[]" value="nep" id="nep" autocomplete="off" checked> Nepali
                    </label>
                    <label class="btn btn-success">
                        <input type="checkbox" name="txtlang[]" value="eng" id="eng" autocomplete="off"> English
                    </label>
                    <label class="btn btn-success">
                        <input type="checkbox" name="txtlang[]" value="chi" id="chi" autocomplete="off"> Chinese
                    </label>
                </div>

            </div>


            <div class="form-group">
                <input type="submit" value="POST" class="btn btn-primary ">
            </div>

        </form>
        <hr>

        <h2>AJAX Records</h2>
        <table class='table table-bordered table-striped '>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>

            <tbody id="ajaxDataReceiver">

            </tbody>

        </table>


    </div><!--end of div content-->


</div><!--end of container-fluid-->