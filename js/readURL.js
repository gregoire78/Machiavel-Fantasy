/**
 * Created by Grégoire on 12/03/2015.
 */

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var url = e.target.result;
            croppy(url);
        };
        reader.readAsDataURL(input.files[0]);

    }
}
function croppy(uurl) {

        var img = '<img id="crop" src="' + uurl + '">';
        $('.crop').empty().html(img);
        $('#crop').cropper({

            preview: $(".preview"),
            aspectRatio: 2 / 3,
            strict: false,
            crop: function (data) {
                // Output the result data for cropping image.
                var json = [
                    '{"x":' + data.x,
                    '"y":' + data.y,
                    '"height":' + data.height,
                    '"width":' + data.width,
                    '"rotate":' + data.rotate + '}'
                ].join();alert(json)
            }

        });

}
