/************************************************
script de verification du formulaire du profil
*************************************************/
$(document).ready(function(){

    /***infos utilisateur***/

	var result = true;
	$('#pseudo_user').bind("keyup focusout", function (){ //quand on écrit dans le champ input avec id #pseudo_user on exécute ceci :
		var pseudo_user = $.trim($(this).val());//on enregistre la valeur du champ input dans pseudo_user
		$.post('ajax/ajax_pseudo.php',{pseudo_user:pseudo_user,pseudo_user_data:pseudo_user_data},function(data){ //ajax: on fait une requete post vers la page php qui va retourné  les données dans la variable data
			if(data!=0)
			{
				$('#error_pseudo_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;</strong> le nom d\'utilisateur <b><i>'+ pseudo_user +'</i></b> éxiste déjà.</div>').show();
				$('#form_pseudo_user').addClass('has-error').removeClass('has-success');
				$('#input0Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
				result = false;
			}
			else if(pseudo_user=="")
			{
				$('#error_pseudo_user').hide();
				$('#form_pseudo_user').addClass('has-error').removeClass('has-success');
				$('#input0Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
				result = false;
			}
			else if(pseudo_user.length>=35) //on vérifie si pseudo_user dépasse 30 caractères
			{
				$('#error_pseudo_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;</strong> le pseudo ne doit pas dépasser <b>35 caractères</b> !</div>').show();
				$('#form_pseudo_user').addClass('has-error').removeClass('has-success');
				$('#input0Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
				result = false;
			}
			else if(pseudo_user.match(/[^0-9A-Za-zàâçéèêëîïôûùüÿñæœ_]/)) //on vérifie si pseudo_usercontient des caractères non valides
			{
				$('#error_pseudo_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;</strong> Veuillez insérer que des lettres ou chiffres dans votre pseudo !</div>').show();
				$('#form_pseudo_user').addClass('has-error').removeClass('has-success');
				$('#input0Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
				result = false;
			}
			else
			{
				$('#error_pseudo_user').hide();
				$('#form_pseudo_user').addClass('has-success').removeClass('has-error');
				$('#input0Status').removeClass('glyphicon-remove').addClass('glyphicon-ok');
				result = true;
			}
		});
	});

	var result_un = true;
	$('#lastname_user').bind("keyup focusout", function (){
		var lastname_user = $.trim($(this).val());
		if(lastname_user=="")
		{
			$('#error_lastname_user').hide();
			$('#form_lastname_user').addClass('has-error').removeClass('has-success');
			$('#input1Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			result_un = false;
		}
		else if(lastname_user.length>=30)
		{
			$('#error_lastname_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> </strong> le prénom ne doit pas dépasser <b>30 caractères</b> !</div>').show();
			$('#form_lastname_user').addClass('has-error').removeClass('has-success');
			$('#input1Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			result_un = false;
		}
		else if(lastname_user.match(/[^A-Za-zàâçéèêëîïôûùüÿñæœ ]/))
		{
			$('#error_lastname_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;</strong> Veuillez insérer que des lettres dans votre nom !</div>').show();
			$('#form_lastname_user').addClass('has-error').removeClass('has-success');
			$('#input1Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			result_un = false;
		}
		else
		{
			$('#error_lastname_user').hide();
			$('#form_lastname_user').addClass('has-success').removeClass('has-error');
			$('#input1Status').removeClass('glyphicon-remove').addClass('glyphicon-ok');
			result_un = true;
		}
	});

	var result_deux = true;
	$('#firstname_user').bind("keyup focusout", function (){
		var firstname_user = $.trim($(this).val());
		if(firstname_user=="")
		{
			$('#error_firstname_user').hide();
			$('#form_firstname_user').addClass('has-error').removeClass('has-success');
			$('#input2Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			result_deux = false;
		}
		else if(firstname_user.length>=30)
		{
			$('#error_firstname_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> </strong> le prénom ne doit pas dépasser <b>30 caractères</b> !</div>').show();
			$('#form_firstname_user').addClass('has-error').removeClass('has-success');
			$('#input2Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			result_deux = false;
		}
		else if(firstname_user.match(/[^A-Za-zàâçéèêëîïôûùüÿñæœ ]/))
		{
			$('#error_firstname_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span>&nbsp;</strong> Veuillez insérer que des lettres dans votre prénom !</div>').show();
			$('#form_firstname_user').addClass('has-error').removeClass('has-success');
			$('#input2Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			result_deux = false;
		}
		else
		{
			$('#error_firstname_user').hide();
			$('#form_firstname_user').addClass('has-success').removeClass('has-error');
			$('#input2Status').removeClass('glyphicon-remove').addClass('glyphicon-ok');
			result_deux = true;
		}
	});

	var result_trois = true;
	$('#email_user').bind("keyup focusout", function (){
		var email_user = $.trim($(this).val());
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		$.post('ajax/ajax_mail.php',{email_user:email_user,email_user_data:email_user_data},function(data){
			if(data!=0)
			{
				$('#error_email_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> </strong> L\'adresse mail <b><i>'+ email_user +'</i></b> éxiste déjà.</div>').show();
				$('#form_email_user').addClass('has-error').removeClass('has-success');
				$('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
				result_trois = false;
			}
			else if(email_user=="")
			{
				$('#error_email_user').hide();
				$('#form_email_user').addClass('has-error').removeClass('has-success');
				$('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
				result_trois = false;
			}
			else if(!emailReg.test(email_user))
			{
				$('#error_email_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> </strong> Ceci n\'est pas une adresse mail valide</div>').show();
				$('#form_email_user').addClass('has-error').removeClass('has-success');
				$('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
				result_trois = false;
			}
			else
			{
				$('#error_email_user').hide();
				$('#form_email_user').addClass('has-success').removeClass('has-error');
				$('#input5Status').addClass('glyphicon-ok').removeClass('glyphicon-remove');
				result_trois = true;
			}
		});
	});

	/*si clique sur submit*/
	$('form').submit(function(){
		var pseudo_user1 = $('#pseudo_user').val();
		pseudo_user1 = $.trim(pseudo_user1);
		if(pseudo_user1=="")
		{
			$('#error_pseudo_user').hide();
			$('#form_pseudo_user').addClass('has-error').removeClass('has-success');
			$('#input0Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			var result_quatre = false;
		}

		var lastname_user1 = $('#lastname_user').val();
		lastname_user1 = $.trim(lastname_user1);
		if(lastname_user1=="")
		{
			$('#error_lastname_user').hide();
			$('#form_lastname_user').addClass('has-error').removeClass('has-success');
			$('#input1Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			var result_cinq = false;
		}

		var firstname_user1 = $('#firstname_user').val();
		firstname_user1 = $.trim(firstname_user1);
		if(firstname_user1=="")
		{
			$('#error_firstname_user').hide();
			$('#form_firstname_user').addClass('has-error').removeClass('has-success');
			$('#input2Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			var result_six = false;
		}

		var email_user1 = $('#email_user').val();
		email_user1 = $.trim(email_user1);
		if(email_user1=="")
		{
			$('#error_email_user').hide();
			$('#form_email_user').addClass('has-error').removeClass('has-success');
			$('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			var result_sept = false;
		}

		if(result==false || result_un==false || result_deux==false || result_trois==false || result_quatre==false || result_cinq==false || result_six==false || result_sept==false)
		{
			return false;
		}
	});

    /***mot de passe***/

    var result_mdp = true;
    $('#password_actuel').bind("keyup focusout", function (){
        var pseudo_user = $(this).val();

    });
});