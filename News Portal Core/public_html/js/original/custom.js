$(document).ready(function () {
    $('.menu ul li.drop-down > a').on('click', function (e) {
        e.preventDefault();
        $(this.nextElementSibling).slideToggle(300);
    });

    $('#categories').select2();

    $('#newsdate').datetimepicker({
        format: 'YYYY-MM-DD hh:mm'
    });

    $(".fancybox").fancybox();


//AjAX
    //insert
    $('form#ajax_form').submit(function (e) {
        e.preventDefault();

        if ($(this).attr('data-update-form') == 'true') {
            return;
        }

        var $this = $(this);
        var name = $this.find('input#name').val();
        var age = $this.find('input#age').val();
        var gender = '';
        var language = [];
        $this.find('input[type=radio]').each(function (i, element) {
            if (element.checked) {
                gender = $(element).val();
            }
        });
        $this.find('input[type=checkbox]').each(function (i, element) {
            if (element.checked) {
                language.push($(element).val());
            }

        });

        var sendData = {
            'do': 'insert_ajax_data',
            'name': name,
            'age': age,
            'gender': gender,
            'language': language
        }

        $.ajax({
            url: baseUrl + '@admin@/ajax.php',
            data: sendData,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                if (data.result == 'success') {
                    alertify.success(data.message);
                    getAjaxData();
                } else {
                    alertify.error(data.message);
                }

            },
            error: function (err) {

            }
        });

    });

    //view ajax


    var getAjaxData = function () {

        $.getJSON(baseUrl + '@admin@/ajax.php', {do: 'get_ajax_data'}, function (data) {
            var ajaxDataReceiver = $('#ajaxDataReceiver');
            if (data.status == 'success') {
                var output = '';

                $(data.result).each(function (i, each) {
                    output += '<tr>';
                    output += '<td>' + ++i + '</td>';
                    output += '<td>' + each.name + '</td>';
                    output += '<td>' + each.age + '</td>';
                    output += '<td>' + '<button class="btn btn-sm btn-primary edit-ajax" data-id="' + each.id + '">Edit</button>&nbsp;&nbsp;<button class="btn btn-sm btn-danger delete-ajax" data-id="' + each.id + '">Delete</button>' + '</td>';
                    output += '</tr>';
                })
                ajaxDataReceiver.html(output);
            } else {
                ajaxDataReceiver.html('');
            }
        });
    }
    getAjaxData();


    //Delete ajax

    $('#ajaxDataReceiver').on('click', '.delete-ajax', function () {
        var id = $(this).data('id');
        alertify.confirm('Are you sure you want to delete.',
            function () {
                $.post(baseUrl + '@admin@/ajax.php', {do: 'delete-ajax', id: id}, function (data) {
                    var data = $.parseJSON(data);
                    if (data.status == 'success') {
                        alertify.success(data.result);
                        getAjaxData();
                    }

                });
            },
            function () {
                alertify.success('Delete Cancelled')
            }
        );
    });


//edit ajax

    $('#ajaxDataReceiver').on('click', '.edit-ajax', function () {
        var id = $(this).data('id');
        $.getJSON(baseUrl + '@admin@/ajax.php', {do: 'edit-ajax', id: id}, function (data) {
            if (data.status == 'success') {
                var formData = data.data;
                var form = $('form#ajax_form');
                form.find('input#name').val(formData.name);
                form.find('input#age').val(formData.age);
                console.log(jQuery.fn.jquery);

                var totGender = ['male', 'female'];

                for (var k = 0; k < totGender.length; k++) {
                    form.find('input#' + totGender[k]).removeAttr('checked');
                    form.find('input#' + totGender[k]).parent('label').removeClass('active');
                }


                if (formData.gender == 'male') {
                    var male = form.find('input#male');
                    male.attr('checked', 'checked');
                    male.parent('label').addClass('active');
                } else {
                    var female = form.find('input#female');
                    female.attr('checked', 'checked');
                    female.parent('label').addClass('active');
                }

                var lang = form.find('input[type=checkbox]');

                var language = formData.lang.split(',');
                var totalLanguage = ['nep', 'eng', 'chi'];


                for (var a = 0; a < totalLanguage.length; a++) {
                    form.find('input#' + totalLanguage[a]).removeProp('checked');
                    form.find('input#' + totalLanguage[a]).parent('label').removeClass('active');

                }


                for (var b = 0; b < language.length; b++) {

                    form.find('input#' + language[b]).prop('checked',true);
                    form.find('input#' + language[b]).parent('label').addClass('active');

                }


                form.find('input[type=submit]').val('Update ' + formData.name);

                var hiddenInput = "<input type='hidden' id ='update-id' value='" + formData.id + "'>";
                form.find('input[type=hidden]').remove();
                form.append(hiddenInput);
                form.attr('data-update-form', 'true');

                $('span#action-type').html('<b>Update</b>');


            } else {

            }
        });

        $('div.content').on('submit', 'form[data-update-form]', function (e) {

            e.preventDefault();

            var $this = $(this);
            var name = $this.find('input#name').val();
            var age = $this.find('input#age').val();
            var gender = '';
            var language = [];
            $this.find('input[type=radio]').each(function (i, element) {
                if ($(this).attr('checked')) {
                    gender = $(element).val();
                }
            });

            $this.find('input[type=checkbox]').each(function (i, element) {

                if ($(this).attr('checked')) {
                    language.push($(element).val());
                }else{
                    console.log('uncheckedddd');
                }

            });



            var id = $this.find('input#update-id').val();
            var sendData = {
                do: 'update-ajax-action',
                name: name,
                age: age,
                gender: gender,
                language: language,
                id: id
            };

            console.log(sendData);
            return;
            $.ajax({
                url: baseUrl + '@admin@/ajax.php',
                data: sendData,
                type: 'post',
                dataType: 'json',
                success: function (data) {


                    if (data.result == 'success') {
                        alertify.success(data.message);
                        setTimeout(function () {
                            location.reload(true);
                        },1000);

                        // getAjaxData();
                    } else {

                        alertify.error(data.message);
                    }

                },
                error: function (err) {

                    console.log('erorrrrrrrrrr');
                }
            });


        });

    });


});
