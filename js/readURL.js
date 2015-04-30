/**
 * Created by Grégoire on 12/03/2015.
 */

function readURL(input) {
    $('body')
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var url = e.target.result;

            croppy(url,'defaut_jeu.png');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function croppy(uurl,defaut) {

    var img_crop = '<img id="crop" src="' + uurl + '">',canvasData, cropBoxData;
    var img_pre_def = '<label for="inputArticleFile" style="cursor: pointer;"><img src="../images/jeux/'+defaut+'"/></label>'

    $('.fileinput-remove').on('click',function(){
        $('#pre_form').empty().html(img_pre_def);
        $('#pre_crop').empty().html('<img src="" />');
        $('.crop').empty();
    });

    $('.crop').empty().html(img_crop);
    $('#crop').cropper({

        preview: $(".preview"),
        aspectRatio: 3/4,
        strict: false,
        autoCropArea: 0.5,
        zoom:-0.1,
        crop: function (data) {
            // Output the result data for cropping image.
            var json = [
                '{"x":' + data.x,
                '"y":' + data.y,
                '"height":' + data.height,
                '"width":' + data.width,
                '"rotate":' + data.rotate + '}'
            ].join()
        },
        built: function () {
            img_crop.cropper('setCanvasData', canvasData);
            img_crop.cropper('setCropBoxData', cropBoxData);
        },


    });
}