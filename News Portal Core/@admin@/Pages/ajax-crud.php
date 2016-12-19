


<div class="container-fluid">

    <div class="content">
        <h2><i class="fa fa-newspaper-o"></i> AJAX <span id="action-type"></span></h2>
        <hr>
        <form id="ajaxForm">
            <div class="row">
                
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="txtname" id="name" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Age</label>
                    <input type="text" name="txtage" id="age" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Gender</label><br>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary">
                            <input type="radio" name="g" id="male" autocomplete="off" value="male"> Male
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" name="g" id="female" autocomplete="off" value="female"> Female
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Language</label><br>




                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-success active">
                            <input type="checkbox" id="nep" autocomplete="off" name="n[]" checked value="nep"> Nepali
                        </label>
                        <label class="btn btn-success">
                            <input type="checkbox" id="eng" autocomplete="off" name="n[]" value="eng"> English
                        </label>
                        <label class="btn btn-success">
                            <input type="checkbox" id="chi" autocomplete="off" name="n[]" value="chi"> Chinese
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" value="POST" class="btn btn-default btn-lg pull-right">
                </div>



            </div>
        </form>

        <hr>

        <h2>Ajax Records</h2>
        <hr>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="ajaxDataReceiver">

            </tbody>
        </table>


    </div><!--end of div content-->


</div><!--end of container-fluid-->