$('document').ready(function(){

	$('.signup-container .form-group input').focusout(function(){
			if($(this)[0].value != ''){
				$(this).addClass('has-value');
			}else{
				$(this).removeClass('has-value');
			}
	});
	$('.signup-container .form-group input').each(function(index){
			if($(this)[0].value != ''){
				$(this).addClass('has-value');
			}else{
				$(this).removeClass('has-value');
			}
	});

	
});


