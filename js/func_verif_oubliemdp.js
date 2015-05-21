/************************************************
 script de verification du formulaire du profil
 *************************************************/
$(document).ready(function(){
    var result = true;
    $('#email_user').bind("keyup focusout", function (){
        var email_user = $(this).val();
        email_user = $.trim(email_user);
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        $.post('ajax/ajax_mail.php',{email_user:email_user},function(data){
            if(email_user=="")
            {
                $('#error_email_user').hide();
                $('#form_email_user').addClass('has-error').removeClass('has-success');
                $('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
                result = false;
            }
            else if(!emailReg.test(email_user))
            {
                $('#error_email_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> </strong> Ceci n\'est pas une adresse mail valide</div>').show();
                $('#form_email_user').addClass('has-error').removeClass('has-success');
                $('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
                result = false;
            }
            else if(data=='1')
            {
                $('#error_email_user').hide();
                $('#form_email_user').addClass('has-success').removeClass('has-error');
                $('#input5Status').addClass('glyphicon-ok').removeClass('glyphicon-remove');
                result = true;
            }
            else
            {
                $('#error_email_user').hide();
                $('#form_email_user').addClass('has-error').removeClass('has-success');
                $('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
                result = false;
            }
        });
    });

    $('#captcha').bind("keyup focusout", function (){
        var captcha = $(this).val();
        captcha = $.trim(captcha);
        if(captcha=="")
        {
            $('#error_captcha').hide();
            $('#form_captcha').addClass('has-error').removeClass('has-success');
        }
        else
        {
            $('#error_captcha').hide();
            $('#form_captcha').addClass('has-success').removeClass('has-error');
        }
    });

    /*si je clique sur l'image du captcha*/
    $('#captcha_image').click(function () {
        $('#captcha').val('');//on efface le champ captcha
        $(this).attr("src", "captcha/image.php");//rafraichir l'image captcha
    });

    /*si clique sur submit*/
    $('#form_envoie_mail_mdp').submit(function(){

        var email_user1 = $('#email_user').val();
        email_user1 = $.trim(email_user1);
        if(email_user1=="")
        {
            $('#error_email_user').hide();
            $('#form_email_user').addClass('has-error').removeClass('has-success');
            $('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
            var result_2 = false;
        }

        var captcha1 = $('#captcha').val();
        captcha1 = $.trim(captcha1);
        if(captcha1=="")
        {
            $('#form_captcha').addClass('has-error').removeClass('has-success');
            var result_3 = false;
        }

        if(result==false || result_2==false|| result_3==false)
        {
            $('#captcha').val('');//on efface le champ captcha
            $('#captcha_image').attr("src", "captcha/image.php");//rafraichir l'image captcha
            return false;
        }
    });
});