/************************************************
script pour les infos bulles dans les formulaires
*************************************************/
$(document).ready(function(){
	
	$(window).resize(function(){
		$('#pseudo_user').popover('hide');
		$('#firstname_user').popover('hide');
		$('#lastname_user').popover('hide');
		$('#password_user').popover('hide');
		$('#repeat_password').popover('hide');
		$('#email_user').popover('hide');
		//profile
		$('#input_lastname_user').popover('hide');
		$('#input_firstname_user').popover('hide');
        $('#new_password').popover('hide');
	});
	
	$('#pseudo_user').keyup(function(){
		$(this).popover('hide');
	});
	$('#firstname_user').keyup(function(){
		$(this).popover('hide');
	});
	$('#lastname_user').keyup(function(){
		$(this).popover('hide');
	});
	$('#password_user').keyup(function(){
		$(this).popover('hide');
	});
	$('#repeat_password').keyup(function(){
		$(this).popover('hide');
	});
	$('#email_user').keyup(function(){
		$(this).popover('hide');
	});
	//profile
	$('#input_lastname_user').keyup(function(){
		$(this).popover('hide');
	});
	$('#input_firstname_user').keyup(function(){
		$(this).popover('hide');
	});
    $('#new_password').keyup(function(){
        $(this).popover('hide');
    });
	
	$('html').click(function(event){
		$('.popover').css('pointer-events','none');//transparent a l'evenement clique
		if(event.target.id != 'pseudo_user') {
		   $('#pseudo_user').popover('hide');
		}
		if(event.target.id != 'firstname_user') {
		   $('#firstname_user').popover('hide');
		}
		if(event.target.id != 'lastname_user') {
		   $('#lastname_user').popover('hide');
		}
		if(event.target.id != 'password_user') {
		   $('#password_user').popover('hide');
		}
		if(event.target.id != 'repeat_password') {
		   $('#repeat_password').popover('hide');
		}
		if(event.target.id != 'email_user') {
		   $('#email_user').popover('hide');
		}
		//profile
		if(event.target.id != 'input_lastname_user') {
		   $('#input_lastname_user').popover('hide');
		}
		if(event.target.id != 'input_firstname_user') {
			$('#input_firstname_user').popover('hide');
		}
        if(event.target.id != 'new_password') {
            $('#new_password').popover('hide');
        }
	 });
});