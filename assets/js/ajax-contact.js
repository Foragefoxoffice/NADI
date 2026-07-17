$(function() {

	// Get the form.
	var form = $('#contact-form');

	// Get the messages div.
	var formMessages = $('.form-message');

	// Set up an event listener for the contact form.
	$(form).submit(function(e) {
		// Stop the browser from submitting the form.
		e.preventDefault();

		// Serialize the form data.
		var formData = $(form).serialize();

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			url: $(form).attr('action'),
			data: formData
		})
		.done(function(response) {
			// Make sure that the formMessages div has the 'success' class.
			$(formMessages).removeClass('error');
			$(formMessages).addClass('success');

			// Set the message text.
			$(formMessages).text(response);

			// Clear the form.
			$('#contact-form input,#contact-form textarea').val('');
		})
		.fail(function(data) {
			// Make sure that the formMessages div has the 'error' class.
			$(formMessages).removeClass('success');
			$(formMessages).addClass('error');

			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured and your message could not be sent.');
			}
		});
	});
	// Subscribe form 1
	$('#subscribe-form').submit(function(e) {
		e.preventDefault();
		var formData = $(this).serialize();
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: formData
		})
		.done(function(response) {
			$('.subscribe-message').text(response).css('color', 'green');
			$('#subscribe-form input').val('');
		})
		.fail(function(data) {
			$('.subscribe-message').text(data.responseText || 'Error occurred').css('color', 'red');
		});
	});

	// Subscribe form 2
	$('#subscribe-form-2').submit(function(e) {
		e.preventDefault();
		var formData = $(this).serialize();
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: formData
		})
		.done(function(response) {
			$('.subscribe-message-2').text(response).css('color', 'green');
			$('#subscribe-form-2 input').val('');
		})
		.fail(function(data) {
			$('.subscribe-message-2').text(data.responseText || 'Error occurred').css('color', 'red');
		});
	});

});
