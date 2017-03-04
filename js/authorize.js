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
    
    // Переменная куда будут располагаться данные файлов
 
    var files;

    // Вешаем функцию на событие
    // Получим данные файлов и добавим их в переменную

    $('input[type=file]').change(function(){
        files = this.files;
    });
      
    $('form[name=insert]').on('click', 'input[name=insert]', function(e){
        e.preventDefault();
       
        $.post(
            '/admin/save',
            {
                first_name: $('form[name=insert] input[name=first_name]').val(),
                last_name: $('form[name=insert] input[name=last_name]').val(),
                email:      $('form[name=insert] input[name=email]').val(), 
                password:   $('form[name=insert] input[name=password]').val(),
                skills:   getValueCheckbox('form[name=insert] input[name=skills]:checkbox:checked'),
                role_id:   $('form[name=insert] input[name=role_id]:checked').val(),
                year:   $('form[name=insert] input[name=year]').val(),
                photo:   files[0]
            },
            function(data){              
                if(data.error !== undefined) {
                    $('.submitInfo').html(data.error);
                }
                else {
                    $('.submitInfo').html(data.error);
                    $('form[name=insert]').hide();
                    $('.submitInfo').html('Сохранено!');
                    $('a.insert').toggleClass('hide');
                }
            },
           'json'
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