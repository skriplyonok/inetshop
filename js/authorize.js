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


    function getValueCheckbox($element){
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