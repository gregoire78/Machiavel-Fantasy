/**
 * Created by Grégoire on 12/03/2015.
 */

function readURL(input) {

    var typefile = input.files[0];

    if (input.files && typefile) {
        if(typefile.type.match(/(png|jpg|gif|jpeg)/))
        {
            var reader = new FileReader();
            reader.onload = function (e) {
                var url = e.target.result;

                croppy(url,'defaut_jeu.png');
            };
            reader.readAsDataURL(typefile);
        }
        else
        {
            $("#inputError").html("Le type de fichier <b>("+typefile.type+")</b> n'est pas pris en charge.<br> Sont autorisées les <b>png, jpg et gif</b>").show();
            $('#myModal').modal('hide');
        }
    }
}
function croppy(uurl,defaut) {

    var img_crop = '<img id="crop" src="' + uurl + '">';
    var img_pre_def = '<img src="../images/jeux/'+defaut+'"/>';

    $('.fileinput-remove').on('click',function(){
        $("#inputError").hide();
        $("#crop").cropper("setAspectRatio",3/4);
        $('#pre_form').empty().removeAttr('data-tooggle').removeAttr('data-target').css('cursor','default').html(img_pre_def);
        $('#pre_crop').empty().html('<img src="" />');
        $('.crop').empty();
    });

    $("#pre_form").attr('data-toggle','modal').attr('data-target','#myModal').css('cursor','pointer');
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
            ].join()
        }
    });
}