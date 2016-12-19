$(document).ready(function () {

    $('.menu ul li.drop-down > a').on('click', function (e) {
        e.preventDefault();
        $(this.nextElementSibling).slideToggle(300);
    });


    $('#categories').select2();

    $('#newsdate').datetimepicker({
        format: 'YYYY-MM-DD hh:mm'
    });

    $('.fancybox').fancybox();


    //ajax

    var ajaxUrl=baseUrl+'@admin@/ajax.php';

    //Create Data
    $('form#ajaxForm').submit(function (e) {

        e.preventDefault();
        var $this = $(this);

        if($this.attr('data-update-form')=="true"){
            return;
        }

        //var formValues=$(this).serialize();
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
            'do':'insert-ajax-data',
            'name': name,
            'age': age,
            'gender': gender,
            'language': language
        };

        $.ajax({
            url: baseUrl+'@admin@/ajax.php',
            data: sendData,
            type: 'post',
            dataType:'json',
            success: function (data) {
                if(data.result=="success"){
                    alertify.success(data.message);
                    getAjaxData();
                }else{
                    alertify.error(data.message);
                }
            },
            error: function (xhr) {
                console.log('here...');
                console.log(xhr);
            }
        });

        //$.post(url,sendData,function(){})
    });//create data end



    /*
     *select data getJSON
     */
    var getAjaxData=function(){
        var ajaxDataReceiver=$('#ajaxDataReceiver');
        $.getJSON(baseUrl+'@admin@/ajax.php',{do:'get-ajax-data'},function(data){
            if(data.status=="success"){
                var output="";
                $(data.result).each(function(i,each){
                    output+="<tr>";
                    for(res in each){
                        if(res=="name" || res=="age" || res=="id"){
                            output+="<td>"+ (++i) +"</td>";
                            output+="<td>"+each.name+"</td>";
                            output+="<td>"+each.age+"</td>";
                            output+="<td width='15%'><button class='btn btn-default btn-sm edit-ajax' data-id='"+each.id+"'>Edit</button> <button class='btn btn-danger btn-sm delete-ajax' data-id='"+each.id+"'>Delete</button></td>";
                            break;
                        }
                    }
                    output+="</tr>";
                });

                ajaxDataReceiver.html(output);
            }else{
                ajaxDataReceiver.html('');
            }

        }).fail(function(data){console.log(data);});
    };
    getAjaxData();



    /**
     * Delete Action
     */
    $('#ajaxDataReceiver').on('click','.delete-ajax',function(){
        var id=$(this).data('id');
        alertify.confirm('Are you sure to delete this ?',
           function(){ 
                $.post(baseUrl+'@admin@/ajax.php',{do:'delete-ajax',id:id},function(data){
                    var data=$.parseJSON(data);

                    if(data.status=="success"){
                        alertify.success(data.result);
                        getAjaxData();
                    }
                });
           },
           function(){alertify.success('Delete Cancelled');}
       );
    });


    
    /**
     * Update Form Setup
     */
    $('#ajaxDataReceiver').on('click','.edit-ajax',function(){

        $.fn.checked = function(value) {

            if(value === true || value === false) {
                // Set the value of the checkbox
                $(this).each(function(){ this.checked = value; });

            } else if(value === undefined || value === 'toggle') {

                // Toggle the checkbox
                $(this).each(function(){ this.checked = !this.checked; });
            }

        };

        var id=$(this).data('id');

        $.getJSON(ajaxUrl,{do:'edit-ajax',id:id},function(data){
            if(data.status=="success"){
                var formData=data.data;
                var form=$('form#ajaxForm');
                form.find('input#name').val(formData.name);
                form.find('input#age').val(formData.age);

                var male=form.find('input#male');
                var female=form.find('input#female');

                if(formData.gender=="male"){
                    male.attr('checked','checked');
                    male.parent('label').addClass('active');
                    female.removeAttr('checked');
                    female.parent('label').removeClass('active');
                }else{
                    female.attr('checked','checked');
                    female.parent('label').addClass('active');
                    male.removeAttr('checked');
                    male.parent('label').removeClass('active');
                }

                var lang=form.find('input[type=checkbox]');
                var language=formData.lang.split(',');



                var totalLanguage=['nep','eng','chi'];
                for(var x=0;x<totalLanguage.length;x++){
                    form.find('input#'+totalLanguage[x]).removeAttr('checked');
                    form.find('input#'+totalLanguage[x]).parent('label').removeClass('active');
                }


                for(var i=0;i<language.length;i++){
                    form.find('input#'+language[i]).checked(true);
                    form.find('input#'+language[i]).parent('label').addClass('active');
                }

                form.find('input[type=submit]').val('Update '+formData.name);
                var hiddenInput="<input type='hidden' id='update-id' value='"+formData.id+"'>";
                form.find('input[type=hidden]').remove();
                form.append(hiddenInput);
                form.attr('data-update-form','true');

                $('span#action-type').html('<b>Update</b>');
            }else{

            }

        });

    });


    /**
     * Update Action
     */
    $('div.content').on('submit','form[data-update-form]',function(e){
        e.preventDefault();
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
            if($(this).attr('checked')){
                language.push($(element).val());
            }
        });
        console.log(language);
        return;


        var id =$this.find('input#update-id').val();

        var sendData={
            do:'update-ajax-action',
            name:name,
            age:age,
            gender:gender,
            lang:language,
            id:id
        };

        $.ajax({
            url: baseUrl+'@admin@/ajax.php',
            data: sendData,
            type: 'post',
            dataType:'json',
            success: function (data) {
                if(data.result=="success"){
                    alertify.success(data.message);
                    setTimeout(function(){
                        location.reload(true);
                    },3000);

                    //getAjaxData();
                }
            },
            error: function (xhr) {
                console.log('here...');
                console.log(xhr);
            }
        });



    });


});
