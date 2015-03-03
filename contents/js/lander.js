$(function(){

	if (!Modernizr.input.placeholder) {

	// if (true) {

		$('.fallBackLabel').css('display', 'block');

	}

	$('.sendEnquiry').on('click', function(e){

		var $form = $('.contactForm form'),
			$thanks = $('.thanks'),
			email = $form.find('#email').val(),
			message = $form.find('#message').val(),
			data = {};

	    if($form[0].checkValidity() === false) {
	   
	      return true;
	   
	    }

		e.preventDefault();

		data.email = email;

		data.message = message;

		data = JSON.stringify(data);

		console.log(data);

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "scripts/enquiry.php",
			data: data,
			success: function(response) {
				$('.form').hide();
				$thanks.show();

			}, 
			error: function(response){
				console.log('fail return', response);
			}
		});

		return false;

	});

});