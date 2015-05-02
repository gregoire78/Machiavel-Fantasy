/**
 * Created by Grégoire on 12/03/2015.
 */

var actu = null;
var modal_win = $('#myModal'); // id de la fentêre modal pour le cropper
var defaut = 'defaut_jeu.png'; // image par defaut
var img_pre_def = '<img src="../images/jeux/'+defaut+'"/>'; //image preview par defaut
var input_error = $("#inputError");

function open_modal(input)
{
    input_error.hide();
    if(input.files && input.files[0])
    {
        if(input.files[0].name.length > 0 && input.files[0].name !== actu)
        {
            if(input.files[0].type.match(/(png|jpg|gif|jpeg)/))
            {
                modal_win.modal('show');
                modal_win.on('shown.bs.modal', function () {
                    if(input.files[0].name !== actu)
                    {
                        size = input.files[0].size;
                        actu = input.files[0].name;
                        $(".pick-a-color-markup").removeClass('input-group').css({width: '0px',height: '0px'});
                        readURL(input);
                    }
                });
            }
            else
            {
                actu = null;
                $("#inputError").html("Le type de fichier <b>("+input.files[0].type+")</b> n'est pas pris en charge.<br> Sont autorisées les <b>images / png, jpeg et gif</b>").show();
                modal_win.modal('hide');
            }
        }
    }
    else
    {
        if($('#inputArticleFile').val() == '')
        {
            modal_win.modal('hide');
            actu = null;
            $("#inputError").hide();
            $("#crop").cropper("setAspectRatio",3/4).cropper("destroy");
            $('#pre_form').empty().removeAttr('data-toggle','data-target').css('cursor','default').html(img_pre_def);
            $('#pre_crop').empty().html('<img src="" />');
            $('.crop').empty();
        }
    }

    $('.fileinput-remove').on('click',function(){
        modal_win.modal('hide');
        actu = null;
        input_error.hide();
        $("#crop").cropper("setAspectRatio",3/4).cropper("destroy");
        $('#pre_form').empty().removeAttr('data-toggle','data-target').css('cursor','default').html(img_pre_def);
        $('#pre_crop').empty().html('<img src="" />');
        $('.crop').empty();
    });
}

function readURL(input) {

    var reader = new FileReader();
    reader.onload = function (e) {
        var url = e.target.result;
        croppy(url,defaut);
    };
    reader.readAsDataURL(input.files[0]);
}
function croppy(uurl) {

    var img_crop = '<img id="crop" src="' + uurl + '">';

    $("#pre_form").attr({'data-toggle':'modal','data-target':'#myModal'}).css('cursor','pointer');
    $('.crop').empty().html(img_crop);
    $('#crop').cropper({

        preview: $(".preview"),
        aspectRatio : 3/4,
        strict: false,
        dragCrop:false,
        responsive:true,
        autoCropArea: 1,
        crop: function (data) {
            // Output the result data for cropping image.
            var json = [
                '{"x":' + data.x,
                '"y":' + data.y,
                '"height":' + data.height,
                '"width":' + data.width,
                '"rotate":' + data.rotate + '}'
            ].join();
            $('#dim').html("<p>x: "+data.x+"<br>y: "+data.y+"<br>height: "+data.height+"<br>width: "+data.width+"<br>Taille(poid): "+size+" octets</p>");
        }
    });
}