/************************************************
script de verification du formulaire d'incsription
*************************************************/
$(document).ready(function(){
	var result = true;
	$('#pseudo_user').bind("keyup focusout", function (){ //quand on écrit dans le champ input avec id #pseudo_user on exécute ceci :
		var pseudo_user = $(this).val();//on enregistre la valeur du champ input dans pseudo_user
		pseudo_user = $.trim(pseudo_user);//on ne compte pas les espace avant et apres la chaine
		$.post('ajax/ajax_pseudo.php',{pseudo_user:pseudo_user},function(data){ //ajax: on fait une requete post vers la page php qui va retourné  les données dans la variable data
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
		var lastname_user = $(this).val();
		lastname_user = $.trim(lastname_user);
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
		var firstname_user = $(this).val();
		firstname_user = $.trim(firstname_user);
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
	$('#password_user').bind("keyup focusout", function (){
		var password_user = $(this).val();
		password_user = $.trim(password_user);
		/*reset confirmer mdp*/
		$('#repeat_password').val('');
		$('#input4Status').removeClass('glyphicon-ok').removeClass('glyphicon-remove');
		$('#error_repeat_password').hide();
		$('#form_repeat_password').removeClass('has-error').removeClass('has-success');
		/*--------------------------------------------------*/
		if(password_user=="")
		{
			$('#error_password_user').hide();
			$('#form_password_user').addClass('has-error').removeClass('has-success').removeClass('has-warning');
			$('#input3Status').addClass('glyphicon-remove').removeClass('glyphicon-ok').removeClass('glyphicon-warning-sign');
			result_trois = false;
		}
		else if(!password_user.match(/[A-Z]/) || !password_user.match(/[a-z]/) || !password_user.match(/[0-9]/) || password_user.length<4)
		{
			$('#error_password_user').html('<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> </strong> Saisir une Majuscule, un nombre et 4 caractères !</div>').show();
			$('#form_password_user').addClass('has-warning').removeClass('has-success').removeClass('has-error');
			$('#input3Status').addClass('glyphicon-warning-sign').removeClass('glyphicon-remove').removeClass('glyphicon-ok');
			result_trois = false;
		}
		else
		{
			$('#error_password_user').hide();
			$('#form_password_user').addClass('has-success').removeClass('has-error').removeClass('has-warning');
			$('#input3Status').removeClass('glyphicon-remove').addClass('glyphicon-ok').removeClass('glyphicon-warning-sign');
			result_trois = true;
		}
	});

	var result_quatre = true;
	$('#repeat_password').bind("keyup focusout", function (){
		var repeat_password = $(this).val();
		repeat_password = $.trim(repeat_password);
		var password_user = $('#password_user').val();
		password_user = $.trim(password_user);
		if(repeat_password=="")
		{
			$('#error_repeat_password').hide();
			$('#form_repeat_password').addClass('has-error').removeClass('has-success');
			$('#input4Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			result_quatre = false;
		}
		else if(repeat_password!=password_user)
		{
			$('#error_repeat_password').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> </strong> Vos mots de passe ne sont pas identiques</div>').show();
			$('#form_repeat_password').addClass('has-error').removeClass('has-success');
			$('#input4Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			result_quatre = false;
		}
		else
		{
			$('#error_repeat_password').hide();
			$('#form_repeat_password').addClass('has-success').removeClass('has-error');
			$('#input4Status').addClass('glyphicon-ok').removeClass('glyphicon-remove');
			result_quatre = true;
		}
	});

	var result_cinq = true;
	$('#email_user').bind("keyup focusout", function (){
		var email_user = $(this).val();
		email_user = $.trim(email_user);
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		$.post('ajax/ajax_mail.php',{email_user:email_user},function(data){
			if(data!=0)
			{
				$('#error_email_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> </strong> L\'adresse mail <b><i>'+ email_user +'</i></b> éxiste déjà.</div>').show();
				$('#form_email_user').addClass('has-error').removeClass('has-success');
				$('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
				result_cinq = false;
			}
			else if(email_user=="")
			{
				$('#error_email_user').hide();
				$('#form_email_user').addClass('has-error').removeClass('has-success');
				$('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
				result_cinq = false;
			}
			else if(!emailReg.test(email_user))
			{
				$('#error_email_user').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times; </span><span class="sr-only">Close</span></button><strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> </strong> Ceci n\'est pas une adresse mail valide</div>').show();
				$('#form_email_user').addClass('has-error').removeClass('has-success');
				$('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
				result_cinq = false;
			}
			else
			{
				$('#error_email_user').hide();
				$('#form_email_user').addClass('has-success').removeClass('has-error');
				$('#input5Status').addClass('glyphicon-ok').removeClass('glyphicon-remove');
				result_cinq = true;
			}
		});
	});

	var result_six = true;
	$("#checkbox").change(function() {
		if(this.checked) {
			$('#form_checkbox').addClass('has-success').removeClass('has-error');
			result_six = true;
		}
		else
		{
			$('#form_checkbox').addClass('has-error').removeClass('has-success');
			result_six = false;
		}
	});

	var result_sept = true;
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
	$('form').submit(function(){
		var pseudo_user1 = $('#pseudo_user').val();
		pseudo_user1 = $.trim(pseudo_user1);
		if(pseudo_user1=="")
		{
			$('#error_pseudo_user').hide();
			$('#form_pseudo_user').addClass('has-error').removeClass('has-success');
			$('#input0Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			var result_huit = false;
		}

		var lastname_user1 = $('#lastname_user').val();
		lastname_user1 = $.trim(lastname_user1);
		if(lastname_user1=="")
		{
			$('#error_lastname_user').hide();
			$('#form_lastname_user').addClass('has-error').removeClass('has-success');
			$('#input1Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			var result_neuf = false;
		}

		var firstname_user1 = $('#firstname_user').val();
		firstname_user1 = $.trim(firstname_user1);
		if(firstname_user1=="")
		{
			$('#error_firstname_user').hide();
			$('#form_firstname_user').addClass('has-error').removeClass('has-success');
			$('#input2Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			var result_dix = false;
		}

		var password_user1 = $('#password_user').val();
		password_user1 = $.trim(password_user1);
		if(password_user1=="")
		{
			$('#error_password_user').hide();
			$('#form_password_user').addClass('has-error').removeClass('has-success').removeClass('has-warning');
			$('#input3Status').addClass('glyphicon-remove').removeClass('glyphicon-ok').removeClass('glyphicon-warning-sign');
			var result_onze = false;
		}

		var repeat_password1 = $('#repeat_password').val();
		repeat_password1 = $.trim(repeat_password1);
		if(repeat_password1=="")
		{
			$('#error_repeat_password').hide();
			$('#form_repeat_password').addClass('has-error').removeClass('has-success');
			$('#input4Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			var result_douze = false;
		}

		var email_user1 = $('#email_user').val();
		email_user1 = $.trim(email_user1);
		if(email_user1=="")
		{
			$('#error_email_user').hide();
			$('#form_email_user').addClass('has-error').removeClass('has-success');
			$('#input5Status').addClass('glyphicon-remove').removeClass('glyphicon-ok');
			var result_treize = false;
		}

		if($('#checkbox').is(':checked'))//si checker
		{
			$('#form_checkbox').addClass('has-success').removeClass('has-error');
		}
		else
		{
			$('#form_checkbox').addClass('has-error').removeClass('has-success');
			var result_quatorze = false;
		}

		var captcha1 = $('#captcha').val();
		captcha1 = $.trim(captcha1);
		if(captcha1=="")
		{
			$('#form_captcha').addClass('has-error').removeClass('has-success');
			var result_quinze = false;
		}

		if(result==false || result_un==false || result_deux==false || result_trois==false || result_quatre==false || result_cinq==false || result_six==false || result_sept==false || result_huit==false || result_neuf==false || result_dix==false || result_onze==false || result_douze==false || result_treize==false || result_quatorze==false || result_quinze==false)
		{
			$('#captcha').val('');//on efface le champ captcha
			$('#captcha_image').attr("src", "captcha/image.php");//rafraichir l'image captcha
			return false;
		}
	});
});