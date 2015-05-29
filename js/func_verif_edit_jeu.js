/**
 * Created by Grégoire on 06/05/2015.
 */
/*****************************************************
 script de verification du formulaire d'edition de jeu
 *****************************************************/
$(document).ready(function(){
    var result = true;
    var id_error_title_jeu = $('#error_title_jeu');
    var id_form_title_jeu = $('#form_title_jeu');
    var id_icon_title_jeu = $('#input0Status');

    var id_error_image_jeu = $('#error_image_jeu');
    var id_form_image_jeu = $('#form_image_jeu');
    var id_icon_image_jeu = $('#input1Status');
    $('#inputArticleTitle').bind("keyup focusout", function () {
        var title_jeu = $(this).val();
        title_jeu = $.trim(title_jeu);
        $.post('../ajax/ajax_titre_jeu.php',{title_jeu:title_jeu},function(data){
            if(data!=0)
            {
                id_error_title_jeu.html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;</strong> Un jeu possède déjà ce titre : <b><i>'+ title_jeu +'</i></b></div>').show();
                id_form_title_jeu.addClass('has-error').removeClass('has-success');
                id_icon_title_jeu.addClass('glyphicon-remove').removeClass('glyphicon-ok');
                result = false;
            }
            else if(title_jeu=="")
            {
                id_error_title_jeu.hide();
                id_form_title_jeu.addClass('has-error').removeClass('has-success');
                id_icon_title_jeu.addClass('glyphicon-remove').removeClass('glyphicon-ok');
                result = false;
            }
            else if(title_jeu.length>=50) //on vérifie si pseudo_user dépasse 30 caractères
            {
                id_error_title_jeu.html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;</strong> le titre ne doit pas dépasser <b>50 caractères</b> !</div>').show();
                id_form_title_jeu.addClass('has-error').removeClass('has-success');
                id_icon_title_jeu.addClass('glyphicon-remove').removeClass('glyphicon-ok');
                result = false;
            }
            else if(title_jeu.match(/[^0-9A-Za-zàâçéèêëîïôûùüÿñæœ\- ']/)) //on vérifie si pseudo_usercontient des caractères non valides
            {
                id_error_title_jeu.html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;</strong> Veuillez insérer que des lettres ou chiffres dans le titre !</div>').show();
                id_form_title_jeu.addClass('has-error').removeClass('has-success');
                id_icon_title_jeu.addClass('glyphicon-remove').removeClass('glyphicon-ok');
                result = false;
            }
            else
            {
                id_error_title_jeu.hide();
                id_form_title_jeu.addClass('has-success').removeClass('has-error');
                id_icon_title_jeu.removeClass('glyphicon-remove').addClass('glyphicon-ok');
                result = true;
            }
        });
    });

    // verifications des entrées dans le ckeditor
    var result_un = true;
    for (var i in CKEDITOR.instances) {
        CKEDITOR.instances[i].on('change', function() {
            CKEDITOR.instances[i].updateElement();

            var text_jeu = $('#editor1').val();
            text_jeu = $.trim(text_jeu);
            var textOnly=text_jeu.replace(/<(?:.|\s)*?>/gm,"");
            if(textOnly.match(['^&nbsp;']) || textOnly == ' '  || textOnly == '')
            {
                $('#error_text_jeu').html('<div class="alert alert-danger alert-dismissible" style="margin-bottom: 0;" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;</strong> Veuillez remplir ce champ </div>').show();
                result_un = false;
            }
            else
            {
                $('#error_text_jeu').hide();
                result_un = true;
            }
        });
    }

    $('#inputGameFile').change(function () {
        id_error_image_jeu.hide();
        id_form_image_jeu.removeClass('has-error');
        id_icon_image_jeu.removeClass('glyphicon-remove');
    });

    // si on clique sur le bouton ajouter/modifier
    $('form').submit(function() {

        var title_jeu1 = $('#inputArticleTitle').val();
        title_jeu1 = $.trim(title_jeu1);
        if (title_jeu1 == "")
        {
            id_error_title_jeu.hide();
            id_form_title_jeu.addClass('has-error').removeClass('has-success');
            id_icon_title_jeu.addClass('glyphicon-remove').removeClass('glyphicon-ok');
            var result_deux = false;
        }

        var text_jeu1 = $('#editor1').val();
        text_jeu1 = $.trim(text_jeu1);
        if (text_jeu1 == "")
        {
            $('#error_text_jeu').hide();
            var result_trois = false;
        }

        var id_input_image = $('#inputGameFile').val();
        id_input_image = $.trim(id_input_image);
        if(id_input_image == "")
        {
            id_error_image_jeu.hide();
            id_form_image_jeu.addClass('has-error');
            id_icon_image_jeu.addClass('glyphicon-remove').css("left","0");
            var result_quatre = false;
        }

        if(result==false || result_un==false || result_deux==false || result_trois==false || result_quatre==false)
        {
            return false;
        }
    });
});