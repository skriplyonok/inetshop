$(document).ready(function() {  
    $('#loginForm').on('click', 'input[name=register]', function(e){
        e.preventDefault();
       
        $.post(
            '/authorize/register',
            { 
                email:      $('input[name=email]').val(), 
                password:   $('input[name=password]').val(),
                save:       $('#save_checkbox').is(':checked')
            },
            function(data){
                
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else {
                    $('.formdata').toggleClass('hide');
                    $('#userEmail').html('Вы зашли как: ' + '<a href="/user/profile/id/'+ data.id + '">' + data.email + '</a>');
                    $('#exit').html('<a id="logout" href="#">Выйти</a>');
                    $('#loginFormDiv').hide();
                    $('#error').empty();
                }
            },
           'json'
        );
    });
    
    $('#loginForm').on('click', 'input[name=login]', function(e){
        e.preventDefault();
        $.post(
            '/authorize/login', 
            { 
                email:      $('input[name=email]').val(), 
                password:   $('input[name=password]').val(),
                save:       $('#save_checkbox').is(':checked')
            },
            function(data){
                if(data.error !== undefined) {
                    $('#error').html(data.error);
                }
                else {
                    $('.formdata').toggleClass('hide');
                    $('#userEmail').html('Вы зашли как: ' + '<a href="/user/profile/id/'+ data.id + '">' + data.email + '</a>');
                    $('#exit').html('<a id="logout" href="#">Выйти</a>');
                    $('#loginFormDiv').hide();
                    $('#error').empty();
                    if(data.role_id == 5) {
                         $('#admin_href').removeAttr('class');
                    }
                }
            },
            'json'
        );
    });
    
    $('body').on('click', '#logout', function(e) {
        e.preventDefault();
        $.post(
            '/authorize/exit', 
            {
                
            },
            function(){ 
                $('.formdata').toggleClass('hide');
                $('#logout').empty();
                //$('#userId').show();
                $('#loginFormDiv').show();
                $('[name="email"]').val('');
                $('[name="password"]').val('');
                $('[name="save"]').removeAttr('checked');
                $('#userEmail').empty();
                $('#admin_href').attr('class', 'hide');
                window.location = '/';
            }
        );
    });

    $('input.edit').click(function(e){
        e.preventDefault();
        window.location = '/admin/update/id/' + $(this).attr('data-id');
    });

    $('.file-upload input[type=file]').change(function (e) {
        var str = $(this).val();
        var name = str/*.slice(str.lastIndexOf('\\') + 1)*/;
        $('.file-upload > div').html(name);
        $('.file-upload > div').css('color', '#000');
    });

    var id = 0;

    $('body').on('click', 'input.delete', function (e) {
        e.preventDefault();
        id = $(this).attr("data-id");
        $("#popup").show();
 
    });
    
    $('a.no').click(function (e) {
        e.preventDefault();
        $("#popup").hide();
    });
    
    $('a.yes').click(function (e) {
        e.preventDefault();

        $.post(
                '/admin/delete',
                {
                    id: id
                },
                function (data) {
                    if (data.error !== undefined) {
                        $('.popup-info').html(data.error);
                    } else {
                        $('.popup-info').html(data.result);
                        $('a.ok').toggleClass('hide');
                        $('a.yes').hide();
                        $('a.no').hide();
                    }
                },
                'json'
                );

    });
    
    $('a.ok').click(function(e){
        e.preventDefault();
        window.location = '/admin/user';
    });


    function getValueCheckbox($element) {
        var skills = '';
         $($element).each(function(){
            if(skills){
                skills += ',';
            }
                 skills += ($(this).val());    

            });
        return skills;
    }
});