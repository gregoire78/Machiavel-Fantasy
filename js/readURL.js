/**
 * Created by Grégoire on 12/03/2015.
 */

var active = null; // mouchard si l'image choisie est dejà selectionné
var modal_win = $('#myModal'); // id de la fentêre modal pour le cropper
var defaut = 'defaut_jeu.png'; // image par defaut

var input_error = $("#inputError"); // balise pour les erreurs

var preview = $(".preview"); // balise des priviews
var img_pre_def = '<img src="../images/jeux/'+defaut+'"/>'; //image preview par defaut

var id_input_color = $(".demo2"); // balise input du color picker
var id_input_image = $("#inputGameFile"); // balise input selection image

//si on change de couleur
id_input_color.colorpicker().on('changeColor.colorpicker', function(event){
    //preview.backgroundColor = event.color.toHex();
    preview.css('background-color',event.color.toHex());
});

function open_modal(input)
{
    input_error.hide();
    if(input.files && input.files[0])
    {
        if(input.files[0].name.length > 0)
        {
            if(input.files[0].type.match(/(png|jpg|gif|jpeg)/))
            {
                if(input.files[0].size < 5000000)
                {
                    modal_win.modal('show');
                    // loader
                    $('#dim').html("Chargement <img src='/images/jquery-ui/ajax-loader.gif'/>");
                    modal_win.on('shown.bs.modal', function () {
                        if(input.files[0].name !== active)
                        {
                            // recup du poid de l'image (octet)
                            size = input.files[0].size;
                            active = input.files[0].name;

                            //initialisation de la couleur (blanc par defaut)
                            id_input_color.colorpicker(function(event){
                                preview.css('background-color',event.color.toHex());
                            });

                            // et enfin on met l'image dans le cropper
                            readURL(input);
                        }
                    });
                }
                else
                {
                    input_error.html("La taille de l'image "+input.files[0].size ).show();
                    reinitialiser();
                }
            }
            else
            {
                input_error.html("Le type de fichier <b>("+input.files[0].type+")</b> n'est pas pris en charge.<br> Sont autorisées les <b>images / png, jpeg et gif</b>").show();
                reinitialiser();
            }
        }
    }
    else
    {
        if(id_input_image.val() == '')
        {
            input_error.hide();
            reinitialiser();
        }
    }

    $('.fileinput-remove').on('click',function(){
        input_error.hide();
        reinitialiser();
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
    $('#crop').hide().cropper({
        responsive:true,
        preview: ".preview",
        aspectRatio : 3/4,
        strict: false,
        dragCrop:false,
        crop: function (data) {
            $("#dataX").val(data.x);
            $("#dataY").val(data.y);
            $("#dataHeight").val(data.height);
            $("#dataWidth").val(data.width);
            $('#dim').html("<p>x: "+data.x+"<br>y: "+data.y+"<br>height: "+data.height+"<br>width: "+data.width+"<br>Taille(poid): "+size+" octets</p>");
        }
    });
}

function reinitialiser()
{
    modal_win.modal('hide');
    active = null;
    $("#crop").cropper("setAspectRatio",3/4).cropper("destroy");
    $('#pre_form').empty().removeAttr('data-toggle','data-target').css('cursor','default').html(img_pre_def);
    $('#pre_crop').empty().html('<img src="" />');
    $('.crop').empty();
}